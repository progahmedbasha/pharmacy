<?php

namespace App\Http\Controllers\Admin\Modules\Finances\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\LogActivityTrait;
use App\Models\Bond;
use App\Models\Account;
use App\Models\Constraint;
use App\Models\ConstraintDetail;
use Yajra\DataTables\DataTables;

class ExchangeVouchersController extends Controller
{
    ////شيكات سندات صرف
    use LogActivityTrait;
    public $account_exist;
    
    public function index(Request $request)
    {
        $this->add_log_activity(null,auth()->user(),'ترحيل سندات الصرف شيكات');


        //return all Suppliers
        if ($request->ajax()) {
            
            $datas = Bond::where(['type'=>'normal_snd_alsirf', 
                                  'is_confirmed'=> 'new', 
                                  'check_is_confirmed'=> 'new', 
                                  'payment_type'=>'check'
                                ])->with('debit_rl','creditor_rl')->orderby('id','DESC')->get();

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
                            <a  class='btn mb-2 btn-success ' href='".route('ExchangeChecksConvert', $data->id)."' id='" . $data->id . "'> ترحيل</a>";
                    

                    return $html;
                })
                ->rawColumns(['actions','created_at','debit_rl','image','value','creditor_rl', 'payment_type'=>'cash'])->make(true);
        }
        
        return view('admin.modules.Finances.Reports.checks_grid')->with(['route_url'=>route('ExchangeChecksReport'), 'page_title'=>'ترحيل سندات الصرف', 'show_actions'=>true]);
    }
    
    public function convert($id)
    {
        $this->add_log_activity(null,auth()->user(),'عمليةترحيل سندات الصرف شيكات');
        
        //check bond exist
        $bond_data = Bond::findOrFail($id);
        
        //check catch paper account exist
        $account_data = Account::where('type', 'exchange_papers')->first();
        
        if(is_null($account_data)){
          	return abort(404);
          }

        
        
        //update bond status
        $bond_data->update(['is_confirmed'=>'confirmed', 'check_is_confirmed'=>'middle']);
        
        //add constraint data
        $constrain_data = [
            'type'      => 'check_sirf',
            'value'     => $bond_data->value,
            'statement' => $bond_data->statement,
            'date'      => date('Y-m-d'),
            'bond_id'   => $bond_data->id
        ];
        
        $new_constraint = Constraint::create($constrain_data);
        
        //add constraint details
        
        //debit value data -- مدين
        $debit_details = [
            'type'          => 'debit',
            'constraint_id' => $new_constraint->id,
            'account_id'    => $bond_data->debit_id,
            'debit_value'   => $bond_data->value,
            'statement'     => $bond_data->statement,
            
        ];
        
        ConstraintDetail::create($debit_details);
        
        //creditor value data -- دائن
        
        $credit_details = [
            'type'           => 'creditor',
            'constraint_id'  => $new_constraint->id,
            'account_id'     => $account_data->id,
            'creditor_value' => $bond_data->value,
            'statement'      => $bond_data->statement,
            
        ];
        
        ConstraintDetail::create($credit_details);
        
        return redirect()->back()->with('success', 'تم الإضافة بنجاح');
        
    }
    
    public function ReceivablesChecksTodayConfirmedList(Request $request)
    {
        $this->add_log_activity(null,auth()->user(),'تحصيل أوراق القبض اليوم');
        
        //check catch paper account exist
        $account_data = Account::where('type', 'exchange_papers')->first();
        
        if(is_null($account_data)){
          	
            $this->account_exist = false;
        }
        else
        {
            $this->account_exist = true;
        }
        
        
        
        //return all Suppliers
        if ($request->ajax()) {
            
            $table_data = Bond::where([
                                  'type'                => 'normal_snd_alsirf', 
                                  'is_confirmed'        => 'confirmed', 
                                  'check_is_confirmed'  => 'middle', 
                                  'check_date'          => date('Y-m-d')
                                ])->with('creditor_rl')
                                ->orderby('id','DESC')->get();

                return DataTables::of($table_data)
                
                   ->editColumn('creditor_rl', function ($data) {
                        return $data->creditor_rl->name;
                    })
                   
                    ->addColumn('actions', function ($data) {
                        if($this->account_exist)
                        {
                            $html = "
                                <a  class='btn mb-2 btn-success ' href='".route('ExchangeconfirmCheck', $data->id)."' id='" . $data->id . "'> تأكيد</a>";
                        }
                        else
                        {
                            $html = "
                                <a  class='btn mb-2 btn-success disabled' href='#' id='" . $data->id . "'> من فضلك أدخل حساب أوراق قبض </a>";
                        }
                        return $html;
                    })
                    ->rawColumns(['actions','creditor_rl', 'payment_type'=>'cash'])->make(true);
                
                
        }
        
        return view('admin.modules.Finances.Reports.confirmed_checks')->with(['route_url'=>route('ExchangeChecksTodayConfirmedList'), 'page_title'=>'تحصيل أوراق القبض اليوم', 'show_actions'=>true]);
    }
    
    public function ExchangeChecksAllConfirmedList(Request $request)
    {
        $this->add_log_activity(null,auth()->user(),'تحصيل كل أوراق القبض ');

        //check catch paper account exist
        $account_data = Account::where('type', 'exchange_papers')->first();
        
        if(is_null($account_data)){
          	
            $this->account_exist = false;
        }
        else
        {
            $this->account_exist = true;
        }
        
        //return all Suppliers
        if ($request->ajax()) {
            
            $table_data = Bond::where([
                                  'type'                => 'normal_snd_alsirf', 
                                  'is_confirmed'        => 'confirmed', 
                                  'check_is_confirmed'  => 'middle', 
                                  //'check_date'          => date('Y-m-d')
                                ])
                                ->where('check_date', '>', date('Y-m-d') )
                                ->with('creditor_rl')
                                ->orderby('id','DESC')->get();

                return DataTables::of($table_data)
                
                   ->editColumn('creditor_rl', function ($data) {
                        return $data->creditor_rl->name;
                    })
                   
                    ->addColumn('actions', function ($data) {
                        
                        if($this->account_exist)
                        {
                            $html = "
                                <a  class='btn mb-2 btn-success ' href='".route('ExchangeconfirmCheck', $data->id)."' id='" . $data->id . "'> تأكيد</a>";
                        }
                        else
                        {
                            $html = "
                                <a  class='btn mb-2 btn-success disabled' href='#' id='" . $data->id . "'> من فضلك أدخل حساب أوراق قبض </a>";
                        }
                        
                        return $html;
                    })
                    ->rawColumns(['actions','creditor_rl', 'payment_type'=>'cash'])->make(true);
                    
        }
        
        return view('admin.modules.Finances.Reports.confirmed_checks')->with(['route_url'=>route('ExchangeChecksAllConfirmedList'), 'page_title'=>'تحصيل كل أوراق القبض ', 'show_actions'=>true]);
    }
    
    public function confirmCheck($id)
    {
        //check bond data exist
        $bond_data = Bond::findOrFail($id);
         
        //check catch paper account exist
        $account_data = Account::where('type', 'exchange_papers')->first();
        
        if(is_null($account_data)){
          	return abort(404);
        }
        
        $bond_data->update([
        'check_is_confirmed' => 'confirmed'
        ]);
        
        //add constraint data
        $constrain_data = [
            'type' => 'check_sirf',
            'value' => $bond_data->value,
            'statement' => $bond_data->statement,
            'date' => date('Y-m-d'),
            'bond_id' => $bond_data->id
        ];
        
        $new_constraint = Constraint::create($constrain_data);
        
        //add constraint details
        
        //debit value data -- مدين
        $debit_details = [
            'type'          => 'debit',
            'constraint_id' => $new_constraint->id,
            'account_id'    => $account_data->id,
            'debit_value'   => $bond_data->value,
            'statement'     => $bond_data->statement,
            
        ];
        
        ConstraintDetail::create($debit_details);
        
        //creditor value data -- دائن
        
        $credit_details = [
            'type'           => 'creditor',
            'constraint_id'  => $new_constraint->id,
            'account_id'     => $bond_data->creditor_id,
            'creditor_value' => $bond_data->value,
            'statement'      => $bond_data->statement,
            
        ];
        
        ConstraintDetail::create($credit_details);
        
        return redirect()->back()->with('success', 'تم الإضافة بنجاح');
        
    }
}
