<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;

use App\Models\InsuranceCompany;
use App\Models\InsuranceCompanyClass;
use App\Models\TreeAccount;

class InsuranceCompanyController extends Controller
{

  private $main_tree_id = 91;

  public function __construct(){
    $this->middleware('auth');
  }

  public function show_all_companies($paginationVal,Request $request){
    $companies = InsuranceCompany::whenSearch($request->search)->with('classes')->paginate($paginationVal);
    return view('admin.insurancecompany.insurancecompanylist',compact('companies','paginationVal'));
  }

  public function add_company_page(){
    return view('admin.insurancecompany.addinsurancecompany');
  }

  public function add_new_company(Request $request){
    //return auth()->user();
    $acc = TreeAccount::where('id',$this->main_tree_id)->with('account')->first();
    $code = ($acc->id_code.'0000')+count($acc->account) + 1;

    $company = new InsuranceCompany();
    $company->company_name_en = $request->insurancecom_name_en;
    $company->company_name_ar = $request->insurancecom_name_ar;
    $company->phone1 = $request->insurancecom_phone;
    $company->phone2 = $request->insurancecom_phone2;
    $company->email = $request->insurancecom_email;
    $company->responsible_name_en = $request->insurancecom_responsible_en;
    $company->responsible_name_ar = $request->insurancecom_responsible_ar;
    $company->cr_number = $request->insurancecom_commertialrecord;
    $company->tax_number = $request->insurancecom_tax;
    $company->save();

    $account = new TreeAccount;
    $account->name_ar = $request->insurancecom_name_en;
    $account->name_en = $request->insurancecom_name_ar;
    $account->account_type = 1;
    $account->parent_id =  $this->main_tree_id;
    $account->balance_type = 1;
    $account->user_id = auth()->user()->id;
    $account->final_account_id = 1;
    $account->id_code = ($acc->id_code.'0000')+$company->id;
    $company->tree()->save($account);

    $class = new InsuranceCompanyClass();
    $class->company_id = $company->id;
    $class->class_name = $request->insurancecom_classification;
    $class->discount_percentage = $request->insurancecom_discount;
    $class->fixed_amount = $request->insurancecom_fixedamount;
    $class->max_amount = $request->insurancecom_maxlimit;
    $class->save();
    Session::flash('success', 'تمت العملية بنجاح!');
    return redirect()->route('insurancecompanylist');
  }

  public function show_company_detail($id){
    $compdetail = InsuranceCompany::where('id',$id)->with('classes')->first();
    return view('admin.insurancecompany.insurancecompanydetail', compact('compdetail'));
  }

  public function add_new_class(Request $request){
    $class = new InsuranceCompanyClass();
    $class->company_id = $request->comp_id;
    $class->class_name = $request->insurancecom_classification;
    $class->discount_percentage = $request->insurancecom_discount;
    $class->fixed_amount = $request->insurancecom_fixedamount;
    $class->max_amount = $request->insurancecom_maxlimit;
    $class->save();
    Session::flash('success', 'تمت العملية بنجاح!');
    return redirect()->back();
  }

  public function edit_class(Request $request){
    $class = InsuranceCompanyClass::find($request->class_id);
    $class->class_name = $request->insurancecom_classification;
    $class->discount_percentage = $request->insurancecom_discount;
    $class->fixed_amount = $request->insurancecom_fixedamount;
    $class->max_amount = $request->insurancecom_maxlimit;
    $class->save();
    Session::flash('success', 'تمت العملية بنجاح!');
    return redirect()->back();
  }

  public function edit_company_page($id){
    $compdetail = InsuranceCompany::find($id);
    return view('admin.insurancecompany.editinsurancecompany',compact('id', 'compdetail'));
  }

  /*public function edit_company(Request $request){
    //return $request;
      $customer = InsuranceCompany::find($request->cus_id);
      $company->name = $request->cus_name;
      $company->phone = $request->cus_phone;
      $company->email = $request->cus_email;
      $company->city = $request->cus_city;
      $company->area = $request->cus_area;
      $company->address = $request->cus_address;
      $company->type = $request->cus_type;
      $company->save();
      if($request->cus_type == 1){
        $company = CustomerCompanyInfo::where('customer_id',$request->cus_id)->first();
        $company->company_name = $request->com_name;
        $company->credit_limit = $request->com_credit_limit;
        $company->credit_duration = $request->com_credit_duration;
        $company->current_balance = $request->com_current_balance;
        $company->save();
      }
      Session::flash('success', 'تمت العملية بنجاح!');
      return redirect()->route('insurancecompanydetail',['id' => $request->cus_id]);
  }*/

  /*
  public function company_activation($id , $status){
    InsuranceCompany::find($id)->update(['isActive' => $status]);
    Session::flash('success', 'تمت العملية بنجاح!');
    return redirect()->back();
  }*/
}
