<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Hash;
use DB;

use App\Models\User;
use App\Models\Item;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\PrescriptionItem;

class DoctorController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('doctor');
    }

    public function edit_profile(Request $request){
        $doctor = Doctor::where('user_doctor_id',auth()->user()->id)->first();
        $doctor->name_en = $request->d_name_en;
        $doctor->name_ar = $request->d_name_ar;
        $doctor->email = $request->d_email;
        $doctor->phone = $request->d_phone;
        $doctor->clinic_type = $request->d_clinic_type;
        $doctor->save();

        $user = User::find(auth()->user()->id);
        $user->name_en = $request->d_name_en;
        $user->name_ar = $request->d_name_ar;
        $user->email = $request->d_email;
        $user->save();

        Session::flash('success', 'تمت العملية بنجاح!');
        return redirect()->back();
    }

    public function edit_password(Request $request){
        $user = User::find(auth()->user()->id);
        if(Hash::check($request->current_pass, $user->password)){
            //return $user;
            $user->password = Hash::make($request->new_pass);
            $user->save();

            Session::flash('success', 'تمت العملية بنجاح!');
            return redirect()->back();
        }
        else{
            //return 'error';
            Session::flash('error', 'براجاء مراجعة كلمة المرور القديمة!');
            return redirect()->back()->withErrors('براجاء مراجعة كلمة المرور القديمة!')->withInput();
        }
    }

    public function show_all_prescription($paginationVal , Request $request){
        $doctor = Doctor::where('user_doctor_id',auth()->user()->id)->first();
        $pres = null;
        if (isset($request)) {
            $search = $request->search_val;
            if(isset($request->search_val)){
                $pres = Prescription::where('doctor_id',$doctor->id)->with('items')->with('patient')->whereHas('patient' , function($q) use($search) {
                $q->where('folder_number',$search)->orWhere('patient_name', 'like', '%' .$search. '%');})->paginate($paginationVal);
            }else if(isset($request->date_from) && isset($request->date_to)){
               $pres = Prescription::where('doctor_id',$doctor->id)->with('items')->with('patient')->whereBetween(DB::raw('DATE(created_at)'), [$request->date_from,$request->date_to])->paginate($paginationVal);
            }else{
                $pres = Prescription::where('doctor_id',$doctor->id)->with('items')->with('patient')->paginate($paginationVal);
            }
        }else{
            $pres = Prescription::where('doctor_id',$doctor->id)->with('items')->with('patient')->paginate($paginationVal);
        }

    	return view('doctor.medicaldescripelist',compact('pres', 'paginationVal'));
    }

    public function add_prescription_page(){
        $patients = Patient::all();
    	return view('doctor.addmedicaldescripe',compact('patients'));
    }

    public function add_new_prescription(Request $request){

        $doctor = Doctor::where('user_doctor_id',auth()->user()->id)->first();
        $patient_id = null;
        if ($request->patient_type == 1) {
            $patient_id = $request->patient_id;
        }else{
            $patient = new Patient();
            $patient->folder_number = $request->patient_file_no;
            $patient->patient_name = $request->patient_name;
            $patient->phone = $request->patient_phone;
            $patient->save();

            $patient_id = $patient->id;
        }
        $pres = new Prescription();
        $pres->doctor_id = $doctor->id;
        $pres->patient_id = $patient_id;
        $pres->save();

        foreach ($request->multi_product as $key => $value) {
            $pres_item = new PrescriptionItem();
            $pres_item->prescription_id = $pres->id;
            $pres_item->item_id = $value;
            $pres_item->quantity = ($request->multi_amount)[$key];
            $pres_item->notes = ($request->multi_notes)[$key];
            $pres_item->save();
        }

        Session::flash('success', 'تمت العملية بنجاح!');
    	return redirect()->route('medicaldesc',['paginationVal'=>10]);
    }

    public function ajax_search($search_val){

        $pro = Item::with('product')->where('name_ar', 'like','%' .$search_val.'%')->orWhere('name_en', 'like','%' .$search_val.'%')->take(10)->get();
        if($pro == ''){
            $response['error'] = true;
            $response['status'] = 0;
            $response['message'] = "No Product";
       /* }else if($pro->total_quantity == 0){
            $response['error'] = true;
            $response['status'] = 1;
            $response['message'] = "There is No Quantity";
        */}else{
            $response['pro'] = $pro;
            $response['error'] = false;
            $response['message'] = "Success";
        }
        return $response;
    }

    public function show_prescription_detail($id){
        $pres = Prescription::with('items')->with('patient')->with('doctor')->find($id);
        return view('doctor.medicaldescripedetail',compact('pres'));
    }
}
