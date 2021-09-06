<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorsRequest;
use Illuminate\Http\Request;
use Hash;
use Session;
use DB;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Prescription;
use App\Models\Customer;
use App\Models\TaxSetting;
use App\Models\SaleBillItemProduct;
use App\Models\SaleBillPayment;
use App\Models\ReturnSaleBill;
use App\Models\SaleBill;
use App\Models\SaleBillItem;
use App\Models\Product;
use App\Models\ProductDate;
use App\Models\TreeAccount;
use App\Models\AccountingEntry;
use App\Models\EntryAction;
use App\Models\Item;
use App\Models\PrescriptionBill;
use App\Http\Traits\Upload_Files;

class ManageDoctorController extends Controller
{
    use Upload_Files;

    private $sale_cash_tree = 48;
    private $sale_forward_tree = 49;

    private $sale_tax_tree = 79;

    /// user tree ///
    private $bank_tree = 65;
    private $safe_tree = 64;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show_all_doctors($paginationVal,Request $request){
        $doctors = Doctor::whenSearch($request->search)->paginate($paginationVal);
        return view('admin.doctor.doctorlist',compact('doctors', 'paginationVal'));
    }

    public function add_doctor_page(){
        return view('admin.doctor.adddoctor');
    }

    public function add_new_doctor(DoctorsRequest  $request){
        $user = new User();
        $user->name_en = $request->doc_name_en;
        $user->name_ar = $request->doc_name_ar;
        $user->email = $request->doc_email;
        $user->password = Hash::make($request->doc_phone);
        $user->user_type_id = 4;
        $user->save();

        $doctor = new Doctor();
        $doctor->doc_code = "1000";
        $doctor->name_en = $request->doc_name_en;
        $doctor->name_ar = $request->doc_name_ar;
        $doctor->email = $request->doc_email;
        $doctor->phone = $request->doc_phone;
        $doctor->clinic_type = $request->doc_clinic_type;
        $doctor->user_doctor_id =$user->id;
        $doctor->user_id = auth()->user()->id;

        $file_name = $this->uploadFiles('doctors',$request->signature, NULL);
        $doctor->signature = $file_name;

        $doctor->save();
        $doctor->doc_code = (int)$doctor->doc_code + $doctor->id;
        $doctor->save();

        Session::flash('success', 'تمت العملية بنجاح!');
        return redirect()->route('doctorlist',['paginationVal'=>10]);
    }

    public function show_doctor_detail($id){
        $docdetail = Doctor::find($id);
        return view('admin.doctor.doctordetail',compact('docdetail'));
    }

    public function edit_doctor_page($id){
        $docdetail = Doctor::find($id);
        return view('admin.doctor.editdoctor',compact('docdetail'));
    }

    public function edit_doctor(Request $request){

        $doctor = Doctor::find($request->doc_id);
        $doctor->name_en = $request->doc_name_en;
        $doctor->name_ar = $request->doc_name_ar;
        $doctor->email = $request->doc_email;
        $doctor->phone = $request->doc_phone;
        $doctor->clinic_type = $request->doc_clinic_type;

        if ($request->signature != ''){
            $file_name = $this->uploadFiles('doctors',$request->signature, NULL);
            $doctor->signature = $file_name;
        }

        $doctor->save();

        $user = User::find($doctor->user_doctor_id);
        $user->name_en = $request->doc_name_en;
        $user->name_ar = $request->doc_name_ar;
        $user->email = $request->doc_email;
        $user->save();

        Session::flash('success', 'تمت العملية بنجاح!');
        return redirect()->route('doctordetail',['id'=>$request->doc_id]);
    }

    /////////////////////////////////////////////////////////////////////////////////

    public function show_all_prescription($paginationVal , Request $request){
        if (isset($request)) {
            $search = $request->search_val;
            if(isset($request->search_val)){
                $pres = Prescription::with('items')->with('patient')->with('doctor')->
                whereHas('patient' , function($q) use($search) {
                $q->where('folder_number',$search)->orWhere('patient_name', 'like', '%' .$search. '%');})->paginate($paginationVal);
            }else if(isset($request->date_from) && isset($request->date_to)){
                $pres = Prescription::with('items')->with('patient')->with('doctor')->
                whereBetween(DB::raw('DATE(created_at)'), [$request->date_from,$request->date_to])->paginate($paginationVal);
            }else{
                $pres = Prescription::with('items')->with('patient')->with('doctor')->paginate($paginationVal);
            }
        }else
            $pres = Prescription::with('items')->with('patient')->with('doctor')->paginate($paginationVal);
        return view('admin.doctor.prescriptionlist',compact('pres', 'paginationVal'));
    }

    public function show_prescription_detail($id){
        $pres = Prescription::with('items')->with('patient')->with('doctor')->find($id);
        return view('admin.doctor.prescriptiondetail',compact('pres'));
    }

    public function print_prescription($id){
        $pres = Prescription::with('items')->with('patient')->with('doctor')->find($id);


        return view('admin.doctor.printprescription',compact('pres'));
    }

    public function prescription_to_bill_page($id){
        $customers = Customer::all();
        $tax = TaxSetting::find(2);
        $pres = Prescription::with('items')->with('patient')->with('doctor')->find($id);
        //return $pres;
        return view('admin.doctor.prescriptionbill',compact('pres','customers','tax'));
    }

    public function new_prescription_bill(Request $request){
        $cus = Customer::where('id',$request->cus_id)->with('tree')->first();

        $bill = new SaleBill();
        $bill->bill_number = 0;
        $bill->bill_date = $request->bill_date;
        $bill->customer_id = $request->cus_id;
        $bill->employee_id = $request->employee_id;
        $bill->total_discount = $request->total_discount;
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

                   // $tot_entry_cost += ($product_date->cost * $q);

                }while($quantity > 0);
            }
        }


        $pres = new PrescriptionBill();
        $pres->prescription_id = $request->pres_id;
        $pres->bill_id = $bill->id;
        $pres->save();

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
        //return redirect()->back()->with('id',$bill->id);
        return redirect()->route('salebilldetail',['id'=>$bill->id])->with('bill_id',$bill->id);
    }

    public function show_all_prescription_bill($paginationVal,Request $request){

        $total_final      = SaleBill::has('prescription_bills')->with('prescription_bills')->sum('total_final');
        $remaining_amount = SaleBill::has('prescription_bills')->with('prescription_bills')->sum('remaining_amount');
        $paid_amount      = $total_final - $remaining_amount;

        if(isset($request)){
            if(isset($request->search_val)){
              $bills = SaleBill::has('prescription_bills')->with('prescription_bills')->with('user')->with('customer')->
               where('bill_number', $request->search_val)->paginate(100);
            }else if(isset($request->date_from) && isset($request->date_to)){
                $bills = SaleBill::has('prescription_bills')->with('prescription_bills')->with('user')->with('customer')->
                whereBetween(DB::raw('DATE(created_at)'), [$request->date_from,$request->date_to])->paginate(100);
            }else{
                $bills = SaleBill::has('prescription_bills')->with('prescription_bills')->with('user')->with('customer')->paginate($paginationVal);
            }
        }else{
            $bills = SaleBill::has('prescription_bills')->with('prescription_bills')->with('user')->with('customer')->paginate($paginationVal);
        }
        return view('admin.doctor.prescriptionbilllist',compact('bills', 'paginationVal','total_final','paid_amount','remaining_amount'));
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

}
