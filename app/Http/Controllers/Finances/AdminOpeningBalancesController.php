<?php

namespace App\Http\Controllers\Admin\Modules\Finances;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Models\Account;
use App\Models\Constraint;
use App\Models\ConstraintDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdminOpeningBalancesController extends Controller
{
    use LogActivityTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $this->add_log_activity(null,auth()->user(),'تم دخول صفحة شجرة الحسابات.');
        //return all Suppliers

        $accounts = Account::all();
         $find = Constraint::where('type','first_balance')
             ->with('contain_details.account_rl')->first();

         $count =  Constraint::where('type','first_balance')->count();

        return view('admin.modules.Finances.openingBalances.index',compact('accounts','find','count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->ajax()){


            if (Constraint::where('type','first_balance')->count() != 0){
                return response()->json(50000,200);
            }//end if

            $this->add_log_activity(null,auth()->user(),'تم دخول صفحة إضافة أرصدة إفتاحية');


            if ($request->ajax()){
                $returnHTML = view("admin.modules.Finances.openingBalances.parts.add_form")
                    ->with([
                        'last_id' => Constraint::count() == 0 ? 0 + 1 : Constraint::latest()->first()->id + 1 ,
                        'accounts' => Account::all(),
                    ])
                    ->render();
                return response()->json(array('success' => true, 'html'=>$returnHTML));
            }
        }
    }//end fun

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()){
            $maindata = $this->validate($request,[
                'date'=>'required',
                'type'=>'required',
            ]);


            $maindata['value'] = $request->totalval;


            $newstore = Constraint::create($maindata);


            $countmadeen = count($request->debit_value);
            for ($i = 0; $i < $countmadeen; $i++) {
                $maddendetails = [];
                $maddendetails['type'] = 'debit';
                $maddendetails['account_id'] = $request->account_id_madeen[$i];
                $maddendetails['debit_value'] = $request->debit_value[$i];
                $maddendetails['creditor_value'] = 0;
                $maddendetails['date'] = $request->date;
                $maddendetails['constraint_id'] = $newstore->id;
                ConstraintDetail::create($maddendetails);
            }

            $countdayyen = count($request->creditor_value);
            for ($g = 0 ,$num = $i +1 ; $g < $countdayyen; $g++,$num++) {
                $dayyendetails = [];
                $dayyendetails['type'] = 'creditor';
                $dayyendetails['account_id'] = $request->account_id_dayyen[$g];
                $dayyendetails['creditor_value'] = $request->creditor_value[$g];
                $dayyendetails['debit_value'] = 0;
                $dayyendetails['date'] = $request->date;
                $dayyendetails['constraint_id'] = $newstore->id;
                ConstraintDetail::create($dayyendetails);
            }

            $this->add_log_activity($newstore,auth()->user(),'تم حفظ رصيد إفتتاحى');

            return response()->json(1,200);



        }//end if

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
        if ($request->ajax()){


            $find = Constraint::with('contain_details.account_rl')->find($id);

            $this->add_log_activity($find,auth()->user(),'تم دخول صفحة تفاصيل قيد يومى');
            if ($request->ajax()){
                $returnHTML = view("admin.modules.Finances.openingBalances.parts.show")
                    ->with([
                        'accounts' => Account::all(),
                        'find'=> $find,
                    ])
                    ->render();

                $forHtml = '';

                foreach ($find->contain_details as $contain_details){
                    $forHtml.= '<tr>
                     <td rowspan="0"></td>
                     <td rowspan="0"></td>
                    <td>'.$contain_details->account_rl->name.'</td>
                    <td>'.$contain_details->debit_value.'</td>
                    <td>'.$contain_details->creditor_value.'</td></tr>
                    ';
                }


                return response()->json(array('success' => true, 'html'=>$returnHTML,'forhtml'=>$forHtml));
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        if ($request->ajax()){




            $find = Constraint::with('contain_details')->find($id);

                $this->add_log_activity($find,auth()->user(),'تم دخول صفحة تعديل رصيد إفتتاحى');


            if ($request->ajax()){
                $returnHTML = view("admin.modules.Finances.openingBalances.parts.edit_form")
                    ->with([
                        'accounts' => Account::all(),
                        'find'=> $find,
                    ])
                    ->render();
                return response()->json(array('success' => true, 'html'=>$returnHTML));
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            $maindata = $this->validate($request, [
                'date' => 'required',
                'type' => 'required',
            ]);


            $maindata['is_edited'] = 'yes';

            $maindata['value'] = $request->totalval;


            Constraint::find($id)->update($maindata);

            ConstraintDetail::where('constraint_id', $id)->delete();


            $newstore = Constraint::find($id);


            $countmadeen = count($request->debit_value);
            for ($i = 0; $i < $countmadeen; $i++) {
                $maddendetails = [];
                $maddendetails['type'] = 'debit';
                $maddendetails['account_id'] = $request->account_id_madeen[$i];
                $maddendetails['debit_value'] = $request->debit_value[$i];
                $maddendetails['creditor_value'] = 0;
                $maddendetails['date'] = $request->date;
                $maddendetails['constraint_id'] = $newstore->id;
                ConstraintDetail::create($maddendetails);
            }

            $countdayyen = count($request->creditor_value);
            for ($g = 0, $num = $i + 1; $g < $countdayyen; $g++, $num++) {
                $dayyendetails = [];
                $dayyendetails['type'] = 'creditor';
                $dayyendetails['account_id'] = $request->account_id_dayyen[$g];
                $dayyendetails['creditor_value'] = $request->creditor_value[$g];
                $dayyendetails['debit_value'] = 0;
                $dayyendetails['date'] = $request->date;
                $dayyendetails['constraint_id'] = $newstore->id;
                ConstraintDetail::create($dayyendetails);
            }

            $this->add_log_activity($newstore, auth()->user(), 'تم تعديل الرصيد الإفتتاحى');

            return response()->json(1, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
