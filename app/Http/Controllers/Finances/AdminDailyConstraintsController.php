<?php

namespace App\Http\Controllers\Admin\Finances;

use App\Http\Controllers\Controller;

use App\Http\Traits\LogActivityTrait;
use App\Models\Account;
use App\Models\Constraint;
use App\Models\ConstraintDetail;
use App\Models\PrintSetting;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdminDailyConstraintsController extends Controller
{
    use LogActivityTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        //return all Suppliers
        if ($request->ajax()) {
//            dd('ddd');
            $datas = Constraint::where('type','daily_constrain')->orderby('id','DESC')->get();

            return DataTables::of($datas)

                ->editColumn('created_at', function ($data) {
                    return date('Y/m/d',strtotime($data->created_at));
                })
                ->addColumn('placeholder', '&nbsp;')


                ->editColumn('daily_constrain', function ($data) {
                    return 'قيد يومى';
                })

                ->addColumn('delete_all', function ($data) {
                    return "<input type='checkbox' class=' delete-all' data-tablesaw-checkall name='delete_all' id='" . $data->id . "'>";
                })
                ->addColumn('actions', function ($data) {
                        $html = "
                    <a href='".route('admin.dailyConstraints.show',$data->id)."'  class='btn mb-2 btn-warning ' id='" . $data->id . "'> <i class='fa fa-eye'></i></a>
                    <a href='".route('admin.dailyConstraints.edit',$data->id)."'  class='btn mb-2 btn-secondary ' id='" . $data->id . "'> <i class='fa fa-edit'></i></a>

                   <button class='btn mb-2 btn-danger delete' id='" . $data->id . "'><i class='fa fa-trash'></i> </button>
                   <a href='".route('admin.dailyConstraints.print',$data->id)."'  class='btn mb-2 btn-info' id='" . $data->id . "'> <i class='fa fa-print'></i></a>

                   ";

                    return $html;
                })
                ->rawColumns(['actions','created_at','daily_constrain','placeholder'])->make(true);



        }
        $accounts = Account::whereDoesntHave('children_accounts')->latest()->get();

        return view('admin.Finances.dailyConstraints.index',compact('accounts'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {



                $returnHTML = view("admin.Finances.dailyConstraints.parts.add_form")
                    ->with([
                        'last_id' => Constraint::count() == 0 ? 0 + 1 : Constraint::latest()->first()->id + 1 ,
                        'accounts' => Account::whereDoesntHave('children_accounts')->latest()->get()
                    ])
                    ->render();
        return $returnHTML;
    }

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

            $maindata['statement'] = $request->main_statement;

            $maindata['value'] = $request->totalval;


            $newstore = Constraint::create($maindata);


            $countmadeen = count($request->debit_value);
            for ($i = 0; $i < $countmadeen; $i++) {
                $maddendetails = [];
                $maddendetails['type'] = 'debit';
                $maddendetails['account_id'] = $request->account_id_madeen[$i];
                $maddendetails['debit_value'] = $request->debit_value[$i];
                $maddendetails['creditor_value'] = 0;
                $maddendetails['statement'] = $request->statement_madeen[$i];
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
                $dayyendetails['statement'] = $request->statement_dayyen[$g];
                $dayyendetails['date'] = $request->date;
                $dayyendetails['constraint_id'] = $newstore->id;
                ConstraintDetail::create($dayyendetails);
            }

            toastr()->success('تم الحفظ');

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



            $find = Constraint::with('contain_details.account_rl')->findOrFail($id);

                $returnHTML = view("admin.Finances.dailyConstraints.parts.show")
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
                    <td>'.$contain_details->statement.'</td>
                    <td>'.$contain_details->debit_value.'</td>
                    <td>'.$contain_details->creditor_value.'</td></tr>
                    ';
                }


                return $returnHTML;


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {


            $find = Constraint::with('contain_details')->find($id);



                $returnHTML = view("admin.Finances.dailyConstraints.parts.edit_form")
                    ->with([
                        'accounts' => Account::all(),
                        'find'=> $find,
                    ])
                    ->render();

                return $returnHTML;
                return response()->json(array('success' => true, 'html'=>$returnHTML));


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

        if ($request->ajax()){
            $maindata = $this->validate($request,[
                'date'=>'required',
                'type'=>'required',
            ]);

            $maindata['statement'] = $request->main_statement;

            $maindata['value'] = $request->totalval;


            Constraint::find($id)->update($maindata);

            ConstraintDetail::where('constraint_id',$id)->delete();


            $newstore = Constraint::find($id);


            $countmadeen = count($request->debit_value);
            for ($i = 0; $i < $countmadeen; $i++) {
                $maddendetails = [];
                $maddendetails['type'] = 'debit';
                $maddendetails['account_id'] = $request->account_id_madeen[$i];
                $maddendetails['debit_value'] = $request->debit_value[$i];
                $maddendetails['creditor_value'] = 0;
                $maddendetails['statement'] = $request->statement_madeen[$i];
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
                $dayyendetails['statement'] = $request->statement_dayyen[$g];
                $dayyendetails['date'] = $request->date;
                $dayyendetails['constraint_id'] = $newstore->id;
                ConstraintDetail::create($dayyendetails);
            }

            toastr()->success('تم الحفظ');

            return response()->json(1,200);



        }//end if
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Constraint::destroy($id);

        return response()->json(1,200);

    }//end fun
    public function delete_all(Request $request){


        //delete all Client had user selected
        Constraint::destroy($request->id);
        return response()->json(1,200);
    }//end fun

    public function Search(Request $request){


        $find = Constraint::where('type','daily_constrain');


        if (!in_array("all",$request->dayeenSelect)) $find->wherehas('contain_details',function ($query)use($request){
            $query->where([['account_id',$request->dayeenSelect],['type','creditor']]);
        });

        if (!in_array("all",$request->maddenSelect)) $find->wherehas('contain_details',function ($query)use($request){
            $query->where([['account_id',$request->maddenSelect],['type','debit']]);
        });

        if ($request->QuedNumber != null) $find->where('id',$request->QuedNumber);

        if ($request->ToDate == null){
            $ToDate = date('Y-m-d');
        }else{
            $ToDate = $request->ToDate;
        }

        if ($request->FromDate != null ){
            $find->whereBetween('date',[$request->FromDate,$ToDate]);
        }




         $out = '';

         foreach ($find->get() as $item){
             $html = "

                    <a href='".route('admin.dailyConstraints.show',$item->id)."'  class='btn mb-2 btn-warning ' id='" . $item->id . "'> <i class='fa fa-eye'></i></a>
                    <a href='".route('admin.dailyConstraints.edit',$item->id)."'  class='btn mb-2 btn-secondary ' id='" . $item->id . "'> <i class='fa fa-edit'></i></a>

                   <button class='btn mb-2 btn-danger  delete' attr_type='search' id='" . $item->id . "'><i class='fa fa-trash'></i> </button>";


             $out.='<tr>
                <td><input type="checkbox" class=" delete-all" data-tablesaw-checkall name="delete_all" id="'.$item->id.'"></td>
                <td>'.$item->id.'</td>
                <td>'.$item->value.'</td>
                <td>'.$item->date.'</td>
                <td>'.date('Y/m/d',strtotime($item->created_at)).'</td>
                <td>'.$html.'</td>
                </tr>
            ';
         }

         return response()->json(['html'=>$out],200);


    }//end fun

    public function print($id){
        $find = Constraint::with('contain_details.account_rl')->findOrFail($id);

        $printsetting = PrintSetting::first();

//        return $find;

        return view('admin.Finances.dailyConstraints.print',compact('find','printsetting'));
    }//end fun
}
