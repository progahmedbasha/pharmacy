<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Session;
use DB;

use App\Models\Item;
use App\Models\Employee;
use App\Models\Customer;
use App\Models\TaxSetting;
use App\Models\Category;
use App\Models\SaleBill;
use App\Models\SaleBillItem;
use App\Models\Product;
use App\Models\ProductDate;
use App\Models\TreeAccount;
use App\Models\AccountingEntry;
use App\Models\EntryAction;
use App\Models\User;
use App\Models\SaleBillItemProduct;
use App\Models\SaleBillPayment;
use App\Models\ReturnSaleBill;
use App\Exports\SaleBillsExport;
use Maatwebsite\Excel\Facades\Excel;

class SalesController extends Controller
{

    /// emp tree ///
    private $pursh_tree = 86;
    private $pursh_tax_tree = 79;

    /// emp tree ///
  private $sale_cash_tree = 48;
  private $sale_forward_tree = 49;

  private $sale_tax_tree = 79;

  /// user tree ///
  private $bank_tree = 65;
  private $safe_tree = 64;

    public function __construct(){
        $this->middleware('auth');
    }

    public function sale_point_page(){
        $products = Item::where('type','!=',2)->with('product')->limit('20')->get();
        //$products=0;
        $employees = Employee::all();
        $customers = Customer::where('type',0)->get();
        $tax = TaxSetting::find(2);
        $categories = Category::whereNull('parent_id')->get();

        return view('admin.sale.pointofsale',compact('categories','products','employees','customers','tax'));
    }

//***************************************************************************

    public function ajax_search_barcode($barcode_val)
    {
        $pro = Product::with('item')->where('barcode', $barcode_val)->first();
        if($pro == ''){
            $response['error'] = true;
            $response['status'] = 0;
            $response['message'] = "No Product";
        }else if($pro->total_quantity == 0){
            $response['error'] = true;
            $response['status'] = 1;
            $response['message'] = "There is No Quantity \n".$pro->barcode."-".$pro->item->name;
        }else{
            $response['pro'] = $pro;
            $response['error'] = false;
            $response['message'] = "Success";
        }
        return $response;
    }

    public function ajax_search_name($product_name)
    {
        $pro = Item::where('name_en','like', '%'.$product_name.'%')
            ->orWhere('name_ar','like', '%'.$product_name.'%')
            ->wherehas('product')->with('product')->get();


        $html = '';

        foreach ($pro as $item){
            $html.='<li class="LiClick" attr_bar="'.$item->product->barcode.'">'.$item->name_en . ' ــــــ '. $item->name_ar.'</li>';
        }


        $response = [];

        if($pro->count() == 0){
            $response['error'] = false;
            $response['status'] = 0;
            $response['message'] = "No Product";
        }elseif($pro->count() > 0){
            $response['html'] = $html;
            $response['error'] = false;
            $response['count'] = $pro->count();
            $response['message'] = "Success";
        }


        return $response;
    }


    //////////////////////// bills ////////////////////////////////////

    public function show_all_bills($paginationVal,Request $request){

        $users = User::where('user_type_id',2)->orWhere('user_type_id',3)->get();
        $customers = Customer::all();

        $bills = SaleBill::with('user')->with('customer');

        if(isset($request->search))
            $bills->where('bill_number', $request->search_val);
        if(isset($request->cus_id))
            $bills->where('customer_id', $request->cus_id);
        if(isset($request->user_id))
            $bills->where('user_id', $request->user_id);
        if(isset($request->date_from) && isset($request->date_to))
            $bills->whereBetween(DB::raw('DATE(created_at)'), [$request->date_from,$request->date_to]);

        if(isset($request->is_paid)){
            if($request->is_paid == 1) //مسددة بالكامل
            {
                $bills->where('remaining_amount', 0);
            }
            elseif($request->is_paid == 2) //لم تسدد
            {
                $bills->whereColumn('remaining_amount', 'total_final');
            }
            elseif($request->is_paid == 3) //مسددة بالكامل
            {
                $bills->whereColumn('remaining_amount', '<', 'total_final')
                ->where('remaining_amount', '!=', 0);
            }
        }


        $bills = $bills->paginate($paginationVal);      
/*
        if(isset($request)){

            $total_returns_data = new ReturnSaleBill();

            if(isset($request->search_val) || isset($request->payment_type)){

              $bills_data = SaleBill::with('user')
                          ->with('customer');


              if(isset($request->search_val))
              {
                  $bills_data->where('bill_number', $request->search_val);
              }
                if(isset($request->payment_type) && $request->payment_type != 0 )
                {
                    if($request->payment_type == 1) //مسددة بالكامل
                    {
                        $bills_data->where('remaining_amount', 0);
                    }
                    elseif($request->payment_type == 2) //لم تسدد
                    {
                        $bills_data->whereColumn('remaining_amount', 'total_final');
                    }
                    elseif($request->payment_type == 3) //مسددة بالكامل
                    {
                        $bills_data->whereColumn('remaining_amount', '<', 'total_final')
                        ->where('remaining_amount', '!=', 0);
                    }
                }

                $bills = $bills_data->paginate(100);

                $total_final_data =  new SaleBill(); //::doesnthave('prescription_bills');
                                //->where('bill_number', $request->search_val)

                $remaining_amount_data = new SaleBill(); //::doesnthave('prescription_bills');


                if(isset($request->search_val))
                {
                    $total_final_data = $total_final_data->where('bill_number', $request->search_val);
                    $remaining_amount_data = $remaining_amount_data->where('bill_number', $request->search_val);

                }

                if(isset($request->payment_type) && $request->payment_type != 0 )
                {

                    if($request->payment_type == 1) //مسددة بالكامل
                    {
                        $bills_data->where('remaining_amount', 0);

                        $total_final_data = $total_final_data->where('remaining_amount', 0);
                        $remaining_amount_data = $remaining_amount_data->where('remaining_amount', 0);
                    }
                    elseif($request->payment_type == 2) //لم تسدد
                    {
                        $bills_data->whereColumn('remaining_amount', 'total_final');

                        $total_final_data = $total_final_data->whereColumn('remaining_amount', 'total_final');
                        $remaining_amount_data = $remaining_amount_data->whereColumn('remaining_amount', 'total_final');
                    }
                    elseif($request->payment_type == 3) //مسدد جزء
                    {
                        $bills_data->whereColumn('remaining_amount', '<', 'total_final')
                            ->where('remaining_amount', '!=', 0);

                        $total_final_data = $total_final_data->whereColumn('remaining_amount', '<', 'total_final')
                            ->where('remaining_amount', '!=', 0);

                        $remaining_amount_data = $remaining_amount_data->whereColumn('remaining_amount', '<', 'total_final')
                            ->where('remaining_amount', '!=', 0);
                    }
                }

                $total_final = $total_final_data->sum('total_final');

                                    //->where('bill_number', $request->search_val)


                $remaining_amount = $remaining_amount_data->sum('remaining_amount');

                $total_returns = $total_returns_data->sum('total_amount');


            }else if(isset($request->date_from) && isset($request->date_to)){

                $bills = SaleBill::with('user')->with('customer')->
                whereBetween(DB::raw('DATE(created_at)'), [$request->date_from,$request->date_to])->paginate(100);

                $total_final = SaleBill::whereBetween(DB::raw('DATE(created_at)'), [$request->date_from,$request->date_to])
                                ->sum('total_final');

                $remaining_amount = SaleBill::whereBetween(DB::raw('DATE(created_at)'), [$request->date_from,$request->date_to])
                                    ->sum('remaining_amount');

                $total_returns = $total_returns_data->whereBetween(DB::raw('DATE(created_at)'), [$request->date_from,$request->date_to])
                    ->sum('total_amount');

            }else{
                $total_final = SaleBill::sum('total_final');
                $remaining_amount = SaleBill::sum('remaining_amount');

                $bills = SaleBill::with('user')->with('customer')->paginate($paginationVal);

                $total_returns = $total_returns_data->sum('total_amount');
            }
        }else{

            $total_final = SaleBill::sum('total_final');
            $remaining_amount = SaleBill::sum('remaining_amount');

            $bills = SaleBill::with('user')->with('customer')->paginate($paginationVal);

            $total_returns = ReturnSaleBill::sum('total_amount');
        }

        $paid_amount = $total_final - $remaining_amount;
*/

        $total_final = 0;
        $paid_amount = 0;
        $remaining_amount = 0;
        $total_returns = 0;

        return view('admin.sale.managebill',compact('bills' ,
            'paginationVal' ,
            'customers',
            'users',
            'total_final' ,
            'paid_amount',
            'remaining_amount',
            'total_returns'
        ));
    }

    public function add_bill_page(){
        $employees = Employee::all();
        $customers = Customer::all();
        $tax = TaxSetting::find(2);

        return view('admin.sale.addbill',compact('employees','customers','tax'));
    }

    public function add_new_sale_bill(Request $request){
        //return $request;
        $a = array('5'=> 2);
        $a['6']=5;
        $a['test']='mmm';

        //return array_key_exists('6',$a);

        $this->validate($request, [
            'cus_id' => 'required',
            'bill_date' => 'required',
            'total_discount' => 'required',
            'total_before_tax' => 'required',
            'total_tax' => 'required',
            'final_total' => 'required',
            'paid_amount' => 'required',
            'remaining_amount' => 'required',
            'due_date' => 'required',
            'pay_way' => 'required',
            'bill_source' => 'required',
        ]);
        $cus = Customer::where('id',$request->cus_id)->with('tree')->first();
        $tot_entry_cost = 0;
        //return $cus;

        $bill = new SaleBill();

        $total_discount = $request->total_discount + $request->bill_extra_discount;

        $bill->bill_number = 0;
        $bill->bill_date = $request->bill_date;
        $bill->customer_id = $request->cus_id;
        $bill->employee_id = $request->employee_id;
        $bill->total_discount = $total_discount;//$request->total_discount;
        $bill->total_before_tax = $request->total_before_tax;
        $bill->total_tax = $request->total_tax;
        $bill->total_final = $request->final_total;
        $bill->due_date = $request->due_date;
        $bill->bill_source = $request->bill_source;
        $bill->user_id = auth()->user()->id;

        $x = ($cus->tree->balance * -1) + $request->paid_amount;
        if($cus->type == 0){
            $bill->is_paid = 1;
            $bill->remaining_amount = $request->remaining_amount;
        }else{

            if($request->final_total <= $request->paid_amount){
                $bill->is_paid = 1;
                $bill->remaining_amount = $request->remaining_amount;
            }else if($x >= $request->final_total){
                $bill->is_paid = 1;
                $bill->remaining_amount = 0;
            }
            else{
                $bill->is_paid = 0;
                $bill->remaining_amount = $request->final_total-$x;
            }
        }
        $bill->save();
        $bill->bill_number = $bill->id;
        $bill->save();

        if($request->paid_amount > 0){
            $payment = new SaleBillPayment();
            $payment->bill_id = $bill->id;
            $payment->user_id = auth()->user()->id;
            $payment->pay_way = $request->pay_way;
            $payment->remaining_amount = $request->final_total - $request->paid_amount;
            if($request->pay_way == 0)
                $payment->cash = $request->paid_amount;
            else
                $payment->visa = $request->paid_amount;
            $payment->save();
        }

        foreach ($request->multi_product as $key => $product) {
            $item = Item::find($product);

            $bill_pro = new SaleBillItem();
            $bill_pro->bill_id = $bill->id;
            $bill_pro->item_id = $product;
            $bill_pro->price = ($request->multi_price)[$key];
            $bill_pro->product_discount = ($request->multi_discount)[$key];
            $bill_pro->tax_value = ($request->multi_tax_val)[$key];
            $bill_pro->quantity = ($request->multi_amount)[$key];
            $bill_pro->total_price = ($request->multi_total)[$key];
            $bill_pro->save();

            if($item->type != 3){
                $quantity = ($request->multi_amount)[$key];
                $q = 0;
                do{
                    $pro = Product::where('item_id',$product)->first();
                    $product_date = ProductDate::where('product_id',$pro->id)->where('quantity','!=',0)->first();
                    //return $pro;
                    if($product_date->quantity >= $quantity){
                        $product_date->quantity = $product_date->quantity - $quantity;
                        $q = $quantity;
                        $quantity = 0;
                    }else{
                        $q = $product_date->quantity;
                        $quantity -= $q;
                        $product_date->quantity = 0;
                    }
                    //return $q;
                    $product_date->save();

                    $sale_pro = new SaleBillItemProduct();
                    $sale_pro->sale_bill_item_id = $bill_pro->id;
                    $sale_pro->product_date_id = $product_date->id;
                    $sale_pro->quantity = $q;
                    $sale_pro->save();

                    $tot_entry_cost += ($product_date->cost * $q);

                }while($quantity > 0);
            }
        }

        $entry = new AccountingEntry();
        $entry->type = 1;
        $entry->title_en = "Due sale invoice number".$bill->id;
        $entry->title_ar = "إستحقاق فاتورة بيع رقم".$bill->id;
        $entry->date = date('Y-m-d');
        $entry->description = "إستحقاق فاتورة بيع رقم".$bill->id;
        $entry->source = "/salebilldetail/".$bill->id;
        $entry->user_id = auth()->user()->id;
        $entry->save();

        //////////////////////// cus ///////////////////////////
        ///////// entry_id  -  tree_id  -  credit  دائن-  debit  مدين
        $this->set_entry($entry->id ,$cus->tree->id ,0 ,$request->final_total);
        //////////////////////// pursh ///////////////////////////////
        if($cus->type == 0)
            $this->set_entry($entry->id ,$this->sale_cash_tree ,$request->total_before_tax ,0);
        else
            $this->set_entry($entry->id ,$this->sale_forward_tree ,$request->total_before_tax ,0);
        ////////////////////////pursh tax ///////////////////////////
        $this->set_entry($entry->id ,$this->sale_tax_tree ,$request->total_tax ,0);

        if($request->paid_amount > 0 || $x > 0){
            $entry = new AccountingEntry();
            $entry->type = 1;
            $entry->title_en = "Pay sale invoice number".$bill->id;
            $entry->title_ar = "دفع فاتورة بيع رقم".$bill->id;
            $entry->date = date('Y-m-d');
            $entry->description = "دفع فاتورة بيع رقم".$bill->id;
            $entry->user_id = auth()->user()->id;
            $entry->save();

            //////////////////////// bank safe ///////////////////////////////
            $user = '';
            if($request->pay_way == 0){
                $user = User::where('id',auth()->user()->id)->with(['tree' => function($q) {$q->where('parent_id',$this->safe_tree); }])->first();
            }else{
                $user = User::where('id',auth()->user()->id)->with(['tree' => function($q) {$q->where('parent_id',$this->safe_tree); }])->first();
            }

            if($cus->type == 0){
                $this->set_entry($entry->id ,$cus->tree->id ,$request->final_total ,0);
                $this->set_entry($entry->id ,($user->tree)[0]->id ,0 ,$request->final_total);
            }
            else{
                $this->set_entry($entry->id ,$cus->tree->id ,$request->paid_amount ,0);
                $this->set_entry($entry->id ,($user->tree)[0]->id ,0 ,$request->paid_amount);
            }

        }

        Session::flash('success', 'تمت العملية بنجاح!');
        return redirect()->back()->with('id',$bill->id);
        //return redirect()->route('managebill');
    }

    public function bill_detail($id){
        $bill = SaleBill::with('user')->with('customer')->with('bill_items')->with('employee')->find($id);
        return view('admin.sale.salebilldetail',compact('bill'));
    }

    public function print_bill($id){
        $bill = SaleBill::with('user')->with('bill_items')->with('user')->find($id);
        return view('admin.sale.printsalebill',compact('bill'));
    }

    public function bil_pay_part(Request $request){
        //return $request->amount_val;
        $bill = SaleBill::find($request->bill_id);


        $payment = new SaleBillPayment();
        $payment->bill_id = $request->bill_id;
        $payment->user_id = auth()->user()->id;
        $payment->pay_way = $request->payment_type;
        $payment->remaining_amount = $bill->remaining_amount - $request->amount_val;
        if($request->payment_type == 0)
            $payment->cash = $request->amount_val;
        else
            $payment->visa = $request->amount_val;
        $payment->save();

        if($request->amount_val == $bill->remaining_amount){
            SaleBill::find($request->bill_id)->update(['is_paid'=>1 , 'remaining_amount' => 0]);
        }else{
            $remaining_amount = $bill->remaining_amount - $request->amount_val;
            SaleBill::find($request->bill_id)->update(['remaining_amount' => $remaining_amount]);
        }
        $cus = Customer::with('tree')->find($request->cus_id);

        $entry = new AccountingEntry();
        $entry->type = 1;
        $entry->title_en = "Pay sale invoice number".$bill->id;
        $entry->title_ar = "دفع فاتورة بيع رقم".$bill->id;
        $entry->date = date('Y-m-d');
        $entry->description = "دفع فاتورة بيع رقم".$bill->id;
        $entry->source = "/salebilldetail/".$bill->id;
        $entry->user_id = auth()->user()->id;
        $entry->save();

        //////////////////////// bank safe ///////////////////////////////
        $user = '';
        if($request->pay_way == 0){
            $user = User::where('id',auth()->user()->id)->with(['tree' => function($q) {$q->where('parent_id',$this->safe_tree); }])->first();
        }else{
            $user = User::where('id',auth()->user()->id)->with(['tree' => function($q) {$q->where('parent_id',$this->bank_tree); }])->first();
        }
        $this->set_entry($entry->id ,$cus->tree->id ,$request->amount_val ,0);
        $this->set_entry($entry->id ,($user->tree)[0]->id ,0 ,$request->amount_val);

        Session::flash('success', 'تمت العملية بنجاح!');
        return redirect()->back();

    }
////////////////////////// return bills ///////////////////////////////////

    /*public function return_bill_list(){
        return view('admin.sale.returnbill');
    }*/



    public function return_bill_page($id){
        $bill = SaleBill::with('user')->with('customer')->with('bill_items.bill_item_product')->with('employee')->find($id);
        return view('admin.sale.returnbillaction',compact('bill'));
    }

    public function return_bill(Request $request){


        $find = SaleBill::findOrFail($request->bill_id);

        $new =  ReturnSaleBill::create([
            'return_date'       => date('Y-m-d'),
            'customer_id'       => $find->customer_id,
            'bill_id'           => $find->id,
            'total_before_tax'  => $find->total_before_tax,
            'total_tax'         => $find->total_tax,
            'total_amount'      => $find->bill_items->count(),
            'user_id'           => auth()->user()->id

        ]);

        $new->return_number = $new->id;
        $new->save();



        $entry = new AccountingEntry();
        $entry->type = 1;
        $entry->title_en = "Due return number ".$new->id." for purchase invoice number".$request->bill_id;
        $entry->title_ar = "إستحقاق إرجاع رقم ".$new->id." لفاتورة بيع رقم".$request->bill_id;
        $entry->date = date('Y-m-d');
        $entry->description = "إستحقاق إرجاع رقم ".$new->id." لفاتورة بيع رقم".$request->bill_id;
        $entry->source = "";
        $entry->user_id = auth()->user()->id;
        $entry->save();



        //////////////////////// supp ///////////////////////////
//        $this->set_entry($entry->id ,$client->tree->id ,0 ,$request->total_final);
        //////////////////////// pursh ///////////////////////////////
        $this->set_entry($entry->id ,$this->sale_cash_tree ,$request->total_before_tax ,0);
        ////////////////////////pursh tax ///////////////////////////
        $this->set_entry($entry->id ,$this->sale_tax_tree ,$request->total_tax ,0);

        $find =  SaleBill::findOrFail($request->bill_id);


        $find->is_paid = 2 ;

        $find->save();

        return redirect()->route('returnbilllist');
    }

    public function return_bill_detail($id){
        $return_bill = ReturnPurchaseBill::with('user')->with('bill')->with('return_products')->with('return_payments')->find($id);
        //return $return_bill;
        return view('admin.purchase.purchasereturnbilldetail',compact('return_bill'));
    }


//////////////////////////// helper ////////////////////////////////////
    function set_entry($entry_id ,$tree_id ,$credit ,$debit){
        $account = TreeAccount::find($tree_id);
        if($account->balance_type == 0){
            $account->balance = $account->balance + $credit;
            $account->balance = $account->balance - $debit;
        }
        else{
            $account->balance = $account->balance - $credit;
            $account->balance = $account->balance + $debit;
        }
        $account->save();

        $action = new EntryAction();
        $action->entry_id = $entry_id;
        $action->tree_id = $tree_id;
        $action->credit = $credit;
        $action->debit = $debit;
        $action->balance = $account->balance;
        $action->save();
    }



//return bills

    public function return_bill_list($paginationVal,Request $request){
       
        $total_final   = round(ReturnSaleBill::sum('total_amount'), 2);
        $return_bill   = ReturnSaleBill::count();

        if(isset($request)){
            if(isset($request->date_from) && isset($request->date_to)){
                $bills = ReturnSaleBill::with(['user', 'bill.customer'])->
                whereBetween(DB::raw('DATE(created_at)'), [$request->date_from,$request->date_to])->paginate(100);
            }else{
                $bills = ReturnSaleBill::whenSearch($request->search)->with(['user', 'bill.customer'])->paginate($paginationVal);
            }
        }else{
            $bills = ReturnSaleBill::whenSearch($request->search)->with(['user', 'bill.customer'])->paginate($paginationVal);
        }

        //return $bills;

        return view('admin.sale.returnbill',compact('bills' , 'paginationVal' ,'total_final', 'return_bill'));
    }

    public function create_return_bill()
    {
        $employees = Employee::all();
        $bills = SaleBill::whereNotIn('id', ReturnSaleBill::get('bill_id'))->get();
        //$tax = TaxSetting::find(2);
        return view('admin.sale.addreturnbill',compact('employees','bills'));
    }

    public function bill_details_ajax(Request $request)
    {
        $bill_data = SaleBill::with('bill_items')->where('id', $request->bill_id)->first();

        return $bill_data;
    }

    public function submit_return_bill(Request $request)
    {
      $new =  ReturnSaleBill::create([
            'return_number'     => $request->return_number,
            'customer_id'       => $request->customer_id,
            'return_date'       => $request->return_date,
            'bill_id'           => $request->bill_id,
            'total_before_tax'  => $request->total_before_tax,
            'total_tax'         => $request->total_tax,
            'total_amount'      => $request->pro_count,
            'user_id'           => auth()->user()->id

        ]);



        $entry = new AccountingEntry();
        $entry->type = 1;
        $entry->title_en = "Due return number ".$new->id." for purchase invoice number".$request->bill_id;
        $entry->title_ar = "إستحقاق إرجاع رقم ".$new->id." لفاتورة بيع رقم".$request->bill_id;
        $entry->date = date('Y-m-d');
        $entry->description = "إستحقاق إرجاع رقم ".$new->id." لفاتورة بيع رقم".$request->bill_id;
        $entry->source = "";
        $entry->user_id = auth()->user()->id;
        $entry->save();



        //////////////////////// supp ///////////////////////////
//        $this->set_entry($entry->id ,$client->tree->id ,0 ,$request->total_final);
        //////////////////////// pursh ///////////////////////////////
        $this->set_entry($entry->id ,$this->sale_cash_tree ,$request->total_before_tax ,0);
        ////////////////////////pursh tax ///////////////////////////
        $this->set_entry($entry->id ,$this->sale_tax_tree ,$request->total_tax ,0);

        $find =  SaleBill::findOrFail($request->bill_id);


        $find->is_paid = 2 ;

        $find->save();

        return redirect()->route('returnbilllist');
    }

    public function export() 
    {
        return Excel::download(new SaleBillsExport, 'salebill.xlsx');
    }


}
