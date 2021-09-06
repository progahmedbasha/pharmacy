<?php

namespace App\Http\Controllers\Admin\Modules\Finances\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\LogActivityTrait;
use App\Models\Bond;
use App\Models\Constraint;
use App\Models\ConstraintDetail;
use Yajra\DataTables\DataTables;


class NormalSanadElQabdReport extends Controller
{
    use LogActivityTrait;
    //
    public function index(Request $request)
    {
        $this->add_log_activity(null,auth()->user(),' ترحيل سندات القبض النقدية');


        //return all Suppliers
        if ($request->ajax()) {
            
            $datas = Bond::where(['type'=>'normal_snd_alqabd', 'is_confirmed'=> 'new', 'payment_type'=>'cash'])->with('debit_rl','creditor_rl')->orderby('id','DESC')->get();

            return DataTables::of($datas)

                ->editColumn('created_at', function ($data) {
                    return date('Y/m/d',strtotime($data->created_at));
                })
                ->editColumn('creditor_rl', function ($data) {
                    return $data->creditor_rl->name;
                })
                ->editColumn('value', function ($data) {
                    return $data->value . ' جـ ';
                })
                ->editColumn('image', function ($data) {
                    return '<img src="'.get_file($data->image).'" class=" rounded" style="height:50px;width:50px"
                             onclick="window.open(this.src)">';
                })
                ->editColumn('debit_rl', function ($data) {
                    return $data->debit_rl->name;
                })

                ->addColumn('actions', function ($data) {
                    
                        $html = "
                            <a  class='btn mb-2 btn-success ' href='".route('convertSandQabd', $data->id)."' id='" . $data->id . "'> تحويل</a>";
                    

                    return $html;
                })
                ->rawColumns(['actions','created_at','debit_rl','image','value','creditor_rl'])->make(true);
        }
        
        return view('admin.modules.Finances.Reports.sanads_grid')->with(['route_url'=>route('NormalSandQabdReport'), 'page_title'=>'ترحيل سندات القبض  ', 'show_actions'=>true]);
    }
    
    public function convert($id)
    {
        $this->add_log_activity(null,auth()->user(),'عملية ترحيل سندات القبض النقدية');
        
        $bond_data = Bond::findOrFail($id);
        
        //update bond status
        $bond_data->update(['is_confirmed'=>'confirmed']);
        
        //add constraint data
        $constrain_data = [
            'type' => 'snd_alqabd',
            'value' => $bond_data->value,
            'statement' => $bond_data->statement,
            'date' => date('Y-m-d'),
            'bond_id' => $bond_data->id
        ];
        
        $new_constraint = Constraint::create($constrain_data);
        
        //add constraint details
        
        //debit value data
        $debit_details = [
            'type' => 'creditor',
            'constraint_id' => $new_constraint->id,
            'account_id' => $bond_data->debit_id,
            'debit_value' => $bond_data->value,
            'statement' => $bond_data->statement,
            
        ];
        
        ConstraintDetail::create($debit_details);
        
        //creditor value data
        $credit_details = [
            'type' => 'creditor',
            'constraint_id' => $new_constraint->id,
            'account_id' => $bond_data->creditor_id,
            'creditor_value' => $bond_data->value,
            'statement' => $bond_data->statement,
            
        ];
        
        ConstraintDetail::create($credit_details);
        
        return redirect()->back()->with('success', 'تم الإضافة بنجاح');
        
    }
    
    public function confirmedList(Request $request)
    {
        $this->add_log_activity(null,auth()->user(),'  سندات القبض النقدية المؤكدة');
        
        //return all Suppliers
        if ($request->ajax()) {
            
            $datas = Bond::where(['type'=>'normal_snd_alqabd', 'is_confirmed'=> 'confirmed', 'payment_type'=>'cash'])->with('debit_rl','creditor_rl')->orderby('id','DESC')->get();

            return DataTables::of($datas)

                ->editColumn('created_at', function ($data) {
                    return date('Y/m/d',strtotime($data->created_at));
                })
                ->editColumn('creditor_rl', function ($data) {
                    return $data->creditor_rl->name;
                })
                ->editColumn('value', function ($data) {
                    return $data->value . ' جـ ';
                })
                ->editColumn('image', function ($data) {
                    return '<img src="'.get_file($data->image).'" class=" rounded" style="height:50px;width:50px"
                             onclick="window.open(this.src)">';
                })
                ->editColumn('debit_rl', function ($data) {
                    return $data->debit_rl->name;
                })

                ->rawColumns(['actions','created_at','debit_rl','image','value','creditor_rl'])->make(true);
        }
        
        return view('admin.modules.Finances.Reports.sanads_grid')->with(['route_url'=>route('sanadQabdConfirmedList'), 'page_title'=>' سندات القبض المؤكدة', 'show_actions'=>false]);
    }
}
