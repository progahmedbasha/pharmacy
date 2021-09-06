<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TaxSetting;

class GeneralSettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show_tax_setting_page(){
        $purchase_tax = TaxSetting::find(1);
        $sale_tax = TaxSetting::find(2);

        return view('admin.generalsetting.taxsetting',compact('purchase_tax','sale_tax'));
    }

    public function update_tax(Request $request){
        $tax = TaxSetting::find($request->tax_id);
        $tax->tax_type = $request->tax_type;
        $tax->tax_value = $request->tax_percentage;
        $tax->save();

        return redirect()->back();
    }

}

