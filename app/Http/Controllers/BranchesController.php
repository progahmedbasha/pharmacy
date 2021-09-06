<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Branch;
use App\Models\Country;
use App\Models\Employee;

class BranchesController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show_all_branches(){
        $branches = Branch::with('employee')->with('country')->get();
        return view('admin.branch.managebranch',compact('branches'));
    }
    
    public function add_branch_page(){
    	$countries = Country::all();
    	$employees = Employee::all();
    	return view('admin.branch.addbranch',compact('countries','employees'));
    }

    public function add_new_branch(Request $request){
        $branch = new Branch();
        $branch->name_en = $request->branch_name_en;
        $branch->name_ar = $request->branch_name_ar;
        $branch->employee_id  = $request->branch_employee ;
        $branch->country_id = $request->branch_country;
        $branch->city = $request->branch_city;
        $branch->address = $request->branch_address;
        $branch->save();

        Session::flash('success', 'تمت العملية بنجاح!');
        return redirect()->route('managebranch');
    }

    
}
