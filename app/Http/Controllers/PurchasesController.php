<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use DB;

use App\Models\Store;
use App\Models\Item;
use App\Models\Employee;
use App\Models\Supplier;
use App\Models\TaxSetting;
use App\Models\PurchaseBill;
use App\Models\PurchaseBillProduct;
use App\Models\Product;
use App\Models\ProductDate;
use App\Models\TreeAccount;
use App\Models\AccountingEntry;
use App\Models\EntryAction;
use App\Models\User;
use App\Models\ReturnPurchaseBill;
use App\Models\ReturnPurchaseProduct;
use App\Models\PurchaseBillPayment;
use App\Models\ReturnPurchaseBillPayment;

class PurchasesController extends Controller
{

    /// emp tree ///
    private $pursh_tree = 86;
    private $pursh_tax_tree = 79;

    /// user tree ///
    private $bank_tree = 65;
    private $safe_tree = 64;

    //////// cost/////////
    private $cost_sale_tree = 114;

    public function __construct()
    {
        $this->middleware('auth');
    }

    //////////////////////// bills ////////////////////////////////////

    public function ajax_search_barcode($barcode_val)
    {
        $pro = Product::with('item')->where('barcode', $barcode_val)->first();

        if($pro == ''){
            $response['error'] = true;
            $response['message'] = "No Product";
        }else{
            $response['pro'] = $pro;
            $response['error'] = false;
            $response['message'] = "Success";
        }
        return $response;
    }

    public function show_all_bills($paginationVal,Request $request){

        $total_final_data = new PurchaseBill();

        $remaining_amount_data = PurchaseBill::whereHas('supplier' , function($q) {
            $q->where('type',1);
        });


        if(isset($request)){
            if(isset($request->search_val) || isset($request->payment_type)){

              $search = $request->search_val;


              $bills_data = PurchaseBill::with('user')->with('supplier');

              if($request->search_val)
              {
                  $bills_data->where('bill_number', $request->search_val);

                  $total_final_data = $total_final_data->where('bill_number', $request->search_val);
                  $remaining_amount_data = $remaining_amount_data->where('bill_number', $request->search_val);
              }

              if($request->payment_type)
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
                  elseif($request->payment_type == 3) //مسددة بالكامل
                  {
                      $bills_data->whereColumn('remaining_amount', '<', 'total_final')
                          ->where('remaining_amount', '!=', 0);

                      $total_final_data = $total_final_data->whereColumn('remaining_amount', '<', 'total_final')
                          ->where('remaining_amount', '!=', 0);
                      $remaining_amount_data = $remaining_amount_data->whereColumn('remaining_amount', '<', 'total_final')
                          ->where('remaining_amount', '!=', 0);

                  }
              }

              $bills = $bills_data->get();//paginate($paginationVal);


            }else if(isset($request->date_from) && isset($request->date_to)){

                $bills = PurchaseBill::with('user')->with('supplier')->
                whereBetween(DB::raw('DATE(bill_date)'), [$request->date_from,$request->date_to])->get();//paginate($paginationVal);

                $total_final_data = $total_final_data->whereBetween(DB::raw('DATE(bill_date)'), [$request->date_from,$request->date_to]);

                $remaining_amount_data = $remaining_amount_data->whereBetween(DB::raw('DATE(bill_date)'), [$request->date_from,$request->date_to]);


            }else{
                $bills = PurchaseBill::with('user')->with('supplier')->paginate($paginationVal);//paginate($paginationVal);
              }
        }else{
            $bills = PurchaseBill::with('user')->with('bill_payments')->with('supplier')->get();//paginate($paginationVal);
        }

        $total_final = $total_final_data->sum('total_final');
        $remaining_amount = $remaining_amount_data->sum('remaining_amount');

        $paid_amount = round($total_final - $remaining_amount, 2);


        return view('admin.purchase.purchasemanagebill',compact('bills' , 'paginationVal' ,'total_final','paid_amount', 'remaining_amount'));
    }

    public function show_bill_page(){
    	$stores = Store::all();
    	$products = Item::where('type',1)->orWhere('type',2)->with('product')->limit(50)->get();
    	$employees = Employee::all();
        $suppliers = Supplier::all();
        $tax = TaxSetting::find(1);
    	return view('admin.purchase.addbill',compact('stores','products','employees','suppliers','tax'));
    }

    public function add_new_purch_bill(Request $request){
        //return $request;

        $this->validate($request, [
            'supp_id' => 'required',
            'bill_date' => 'required',
            'total_discount' => 'required',
            'total_before_tax' => 'required',
            'total_tax' => 'required',
            'final_total' => 'required',
            'paid_amount' => 'required',
            'remaining_amount' => 'required',
            'due_date' => 'required',
            'pay_way' => 'required',
            'store_id' => 'required',
        ]);
        $supp = Supplier::with('tree')->find($request->supp_id);
        $store = Store::with('tree')->find($request->store_id);
        //$user = User::where('id',auth()->user()->id)->with(['tree' => function($q) {$q->where('parent_id',$this->safe_tree); }])->first();
        //return $user;

        $bill = new PurchaseBill();

        $total_discount = $request->total_discount + $request->bill_extra_discount;

        $bill->bill_number = 0;
        $bill->bill_date = $request->bill_date;
        $bill->supplier_id = $request->supp_id;
        $bill->employee_id = $request->employee_id;
        $bill->total_discount = $total_discount;
        $bill->total_before_tax = $request->total_before_tax;
        $bill->total_tax = $request->total_tax;
        $bill->total_final = $request->final_total;
        //$bill->paid_amount = $request->paid_amount;
        $bill->due_date = $request->due_date;
        //$bill->pay_way = $request->pay_way;
        $bill->user_id = auth()->user()->id;
        $bill->store_id = $request->store_id;


        $x = ($supp->tree->balance * -1) + $request->paid_amount;
        if($supp->type == 0){
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

        //return $request;
        //return $bill;
        $bill->save();

        $bill->bill_number = $bill->id;
        $bill->save();

        if($request->paid_amount > 0){
            $payment = new PurchaseBillPayment();
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
        //return $request;
        foreach ($request->multi_product as $key => $product) {
            $pro = Product::where('item_id',$product)->first();



            $product_date = new ProductDate();
            $product_date->product_id = $pro->id;
           // $product_date->production_date = ($request->multi_production_date)[$key];
            $product_date->expire_date = ($request->multi_expire_date)[$key];
            $product_date->quantity = ($request->multi_amount)[$key];
            $product_date->cost = ($request->multi_price)[$key];
            $product_date->store_id  = $request->store_id;
            $product_date->note = ($request->multi_note)[$key];

            $product_date->save();

            $bill_pro = new PurchaseBillProduct();
            $bill_pro->bill_id = $bill->id;
            $bill_pro->product_id = $product_date->id;
            $bill_pro->product_discount = ($request->multi_discount)[$key];
            $bill_pro->tax_value = ($request->multi_tax_val)[$key];
            $bill_pro->quantity = ($request->multi_amount)[$key];
            $bill_pro->total_price = ($request->multi_total)[$key];
            $bill_pro->save();
        }

        $entry = new AccountingEntry();
        $entry->type = 1;
        $entry->title_en = "Due purchase invoice number".$bill->id;
        $entry->title_ar = "إستحقاق فاتورة شراء رقم".$bill->id;
        $entry->date = date('Y-m-d');
        $entry->description = "إستحقاق فاتورة شراء رقم".$bill->id;
        $entry->source = "/purchasebilldetail/".$bill->id;
        $entry->user_id = auth()->user()->id;

        $entry->save();

        //////////////////////// supp ///////////////////////////
        $this->set_entry($entry->id ,$supp->tree->id ,$request->final_total ,0);
        //////////////////////// pursh ///////////////////////////////
        $this->set_entry($entry->id ,$this->pursh_tree ,0 ,$request->total_before_tax);
        ////////////////////////pursh tax ///////////////////////////
        $this->set_entry($entry->id ,$this->pursh_tax_tree ,0 ,$request->total_tax);

        if($request->paid_amount > 0){
            $entry = new AccountingEntry();
            $entry->type = 1;
            $entry->title_en = "Pay purchase invoice number".$bill->id;
            $entry->title_ar = "دفع فاتورة شراء رقم".$bill->id;
            $entry->date = date('Y-m-d');
            $entry->description = "دفع فاتورة شراء رقم".$bill->id;
            $entry->source = "/purchasebilldetail/".$bill->id;
            $entry->user_id = auth()->user()->id;

            $entry->save();

            //////////////////////// bank safe ///////////////////////////////
            $user = '';
            if($request->pay_way == 0){
                $user = User::where('id',auth()->user()->id)->with(['tree' => function($q) {$q->where('parent_id',$this->safe_tree); }])->first();
            }else{
                $user = User::where('id',auth()->user()->id)->with(['tree' => function($q) {$q->where('parent_id',$this->bank_tree); }])->first();
            }

            /*if($supp->type == 0){
                $this->set_entry($entry->id ,$supp->tree->id ,0 ,$request->final_total);
                $this->set_entry($entry->id ,($user->tree)[0]->id ,$request->final_total ,0);
            }else{
                $this->set_entry($entry->id ,$supp->tree->id ,0 ,$request->paid_amount);
                $this->set_entry($entry->id ,($user->tree)[0]->id ,$request->paid_amount ,0);
            }*/
        }

        Session::flash('success', 'تمت العملية بنجاح!');
        return redirect()->back()->with('id',$bill->id);
    }

    public function bill_detail($id){
        $bill = PurchaseBill::with('user')->with('supplier')->with('bill_products')->with('employee')->with('store')->find($id);

        return view('admin.purchase.purchasebilldetail',compact('bill'));
    }

    public function print_bill($id){
        $bill = PurchaseBill::with('user')->with('supplier')->with('bill_products')->with('employee')->with('store')->find($id);
        return view('admin.purchase.printpurchasebill',compact('bill'));
    }

    public function bil_pay_part(Request $request){
        //return $request->amount_val;
        $bill = PurchaseBill::find($request->bill_id);
        $payment = new PurchaseBillPayment();
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
            PurchaseBill::find($request->bill_id)->update(['is_paid'=>1 , 'remaining_amount' => 0]);
        }else{
            $remaining_amount = $bill->remaining_amount - $request->amount_val;
            PurchaseBill::find($request->bill_id)->update(['remaining_amount' => $remaining_amount]);
        }
        $supp = Supplier::with('tree')->find($request->supp_id);

        $entry = new AccountingEntry();
        $entry->type = 1;
        $entry->title_en = "Pay purchase invoice number".$bill->id;
        $entry->title_ar = "دفع فاتورة شراء رقم".$bill->id;
        $entry->date = date('Y-m-d');
        $entry->description = "دفع فاتورة شراء رقم".$bill->id;
        $entry->source = "/purchasebilldetail/".$bill->id;
        $entry->user_id = auth()->user()->id;
        $entry->save();

        //////////////////////// bank safe ///////////////////////////////
        $user = '';
        if($request->pay_way == 0){
            $user = User::where('id',auth()->user()->id)->with(['tree' => function($q) {$q->where('parent_id',$this->safe_tree); }])->first();
        }else{
            $user = User::where('id',auth()->user()->id)->with(['tree' => function($q) {$q->where('parent_id',$this->bank_tree); }])->first();
        }
        $this->set_entry($entry->id ,$supp->tree->id ,0 ,$request->amount_val);
        $this->set_entry($entry->id ,($user->tree)[0]->id ,$request->amount_val ,0);

        Session::flash('success', 'تمت العملية بنجاح!');
        return redirect()->back();

    }

    ////////////////////////////// return bill ///////////////////////////////////////

    public function return_bill_list($paginationVal,Request $request){

        if (isset($request)){
            if(isset($request->date_from) && isset($request->date_to)) {
                $return_bill = ReturnPurchaseBill::with('bill')
                    ->with('return_products')->with('user')
                    ->whereBetween(DB::raw('DATE(created_at)'), [$request->date_from, $request->date_to])
                    ->get();
            }else{
                $return_bill = ReturnPurchaseBill::whenSearch($request->search)->with('bill')->with('return_products')->with('user')->paginate($paginationVal);
            }
        }else{
            $return_bill = ReturnPurchaseBill::whenSearch($request->search)->with('bill')->with('return_products')->with('user')->paginate($paginationVal);
        }


        return view('admin.purchase.purchasereturnbill',compact('return_bill','paginationVal'));
    }

    public function return_bill_page($id){
        $bill = PurchaseBill::with('user')->with('supplier')->with('bill_products')->with('employee')->with('store')->find($id);
        //return $bill;
        return view('admin.purchase.purchasereturnbillaction',compact('bill'));
    }

    public function return_bill(Request $request){
        //return auth()->user()->id;
        $bill = PurchaseBill::with('store')->find($request->bill_id);
        $supp = Supplier::with('tree')->find($request->supp_id);
        $store = Store::with('tree')->find($bill->store_id);

        $return_bill = new ReturnPurchaseBill();
        $return_bill->return_number = 0;
        $return_bill->return_date = date('Y-m-d');
        $return_bill->bill_id = $request->bill_id;
        $return_bill->total_before_tax = $request->total_before_tax;
        $return_bill->total_tax = $request->total_tax;
        $return_bill->total_amount = $request->total_final;
        $return_bill->payment_status = $request->payment_status;
        if($supp->type == 1 )
            $return_bill->isClosed = 1;
        else if($supp->type == 0 && $request->total_final == $request->paid_amount)
            $return_bill->isClosed = 1;
        else
            $return_bill->isClosed = 0;
        $return_bill->user_id = auth()->user()->id;
        $return_bill->save();
        $return_bill->return_number = $return_bill->id;
        $return_bill->save();

        if($request->paid_amount > 0){
            $return_payment = new ReturnPurchaseBillPayment();
            $return_payment->return_id = $return_bill->id;
            $return_payment->paid_amount = $request->paid_amount;
            $return_payment->user_id = auth()->user()->id;
            $return_payment->pay_way = $request->pay_way;
            $return_payment->remaining_amount = $bill->total_final - $request->paid_amount;
            $return_payment->save();
        }

        foreach ($request->multi_product as $key => $value) {
            $return_product = new ReturnPurchaseProduct();
            $return_product->return_id = $return_bill->id;
            $return_product->bill_product_id = $value;
            $return_product->quantity = ($request->multi_quantity)[$key];
            $return_product->tax = ($request->multi_tax)[$key];
            $return_product->amount = ($request->multi_total)[$key];
            $return_product->save();

            $bill_product = PurchaseBillProduct::with('product_date')->find($value);
            $product_date = ProductDate::find($bill_product->product_id);
            $product_date->quantity = $product_date->quantity - ($request->multi_quantity)[$key];
            $product_date->save();
        }

        $entry = new AccountingEntry();
        $entry->type = 1;
        $entry->title_en = "Due return number ".$return_bill->id." for purchase invoice number".$request->bill_id;
        $entry->title_ar = "إستحقاق إرجاع رقم ".$return_bill->id." لفاتورة شراء رقم".$request->bill_id;
        $entry->date = date('Y-m-d');
        $entry->description = "إستحقاق إرجاع رقم ".$return_bill->id." لفاتورة شراء رقم".$request->bill_id;
        $entry->source = "/purchasereturnbilldetail/".$return_bill->id;
        $entry->user_id = auth()->user()->id;
        $entry->save();

        //////////////////////// supp ///////////////////////////
        $this->set_entry($entry->id ,$supp->tree->id ,0 ,$request->total_final);
        //////////////////////// pursh ///////////////////////////////
        $this->set_entry($entry->id ,$this->pursh_tree ,$request->total_before_tax ,0);
        ////////////////////////pursh tax ///////////////////////////
        $this->set_entry($entry->id ,$this->pursh_tax_tree ,$request->total_tax ,0);

        if($request->payment_status == 0 || $request->payment_status == 2){
            if($request->paid_amount > 0){
                $entry = new AccountingEntry();
                $entry->type = 1;
                $entry->title_en = "Pay return number ".$return_bill->id." for purchase invoice number".$request->bill_id;
                $entry->title_ar = "دفع الإرجاع رقم ".$return_bill->id." لفاتورة شراء رقم".$request->bill_id;
                $entry->date = date('Y-m-d');
                $entry->description = "دفع الإرجاع رقم ".$return_bill->id." لفاتورة شراء رقم".$request->bill_id;
                $entry->source = "/purchasereturnbilldetail/".$return_bill->id;
                $entry->user_id = auth()->user()->id;
                $entry->save();

                //////////////////////// bank safe ///////////////////////////////
                $user = User::where('id',auth()->user()->id)->with(['tree' => function($q) {$q->where('parent_id',$this->safe_tree); }])->first();
                $this->set_entry($entry->id ,$supp->tree->id ,$request->paid_amount ,0);
                $this->set_entry($entry->id ,($user->tree)[0]->id ,0 ,$request->paid_amount);
            }
        }

        Session::flash('success', 'تمت العملية بنجاح!');
        return redirect()->route('purchasereturnbill');
    }

    public function return_bill_detail($id){
        $return_bill = ReturnPurchaseBill::with('user')->with('bill')->with('return_products')->with('return_payments')->find($id);
        //return $return_bill;
        return view('admin.purchase.purchasereturnbilldetail',compact('return_bill'));
    }

    public function return_bil_pay_part(Request $request){
        $payments = ReturnPurchaseBillPayment::where('return_id',$request->return_id)->sum('paid_amount');
        $return_bill = ReturnPurchaseBill::find($request->return_id);

        $payment = new ReturnPurchaseBillPayment();
        $payment->return_id = $request->return_id;
        $payment->paid_amount = $request->amount_val;
        $payment->user_id = auth()->user()->id;
        $payment->pay_way = $request->payment_type;
        $payment->remaining_amount = $return_bill->total_amount - round($payments,2) - $request->amount_val;
        $payment->save();

        if($return_bill->total_amount == round($payments,2)){
            ReturnPurchaseBill::find($request->return_id)->update(['isClosed' => 1 , 'payment_status' => 0]);
        }else{
           ReturnPurchaseBill::find($request->return_id)->update(['payment_status' => 2]);
        }
        $supp = Supplier::with('tree')->find($request->supp_id);

        $entry = new AccountingEntry();
        $entry->type = 1;
        $entry->title_en = "Pay return number ".$return_bill->id." for purchase invoice number".$return_bill->bill_id;
        $entry->title_ar = "دفع الإرجاع رقم ".$return_bill->id." لفاتورة شراء رقم".$return_bill->bill_id;
        $entry->date = date('Y-m-d');
        $entry->description = "دفع الإرجاع رقم ".$return_bill->id." لفاتورة شراء رقم".$return_bill->bill_id;
        $entry->source = "/purchasereturnbilldetail/".$return_bill->id;
        $entry->user_id = auth()->user()->id;
        $entry->save();

        //////////////////////// bank safe ///////////////////////////////
        $user = User::where('id',auth()->user()->id)->with(['tree' => function($q) {$q->where('parent_id',$this->safe_tree); }])->first();
        $this->set_entry($entry->id ,$supp->tree->id ,$request->amount_val ,0);
        $this->set_entry($entry->id ,($user->tree)[0]->id ,0 ,$request->amount_val);

        Session::flash('success', 'تمت العملية بنجاح!');
        return redirect()->back();
    }


    ///////////////////////////////// Helper /////////////////////////////////////

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
}
