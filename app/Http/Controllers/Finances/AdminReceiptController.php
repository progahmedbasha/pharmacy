<?php

namespace App\Http\Controllers\Finances;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Account;
use App\Models\Bond;
use App\Models\PaymentType;
use App\Models\PrintSetting;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdminReceiptController extends Controller
{
    use LogActivityTrait,Upload_Files;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $datas = Bond::where('type','normal_snd_alqabd')->with('debit_rl','creditor_rl')->orderby('id','DESC')->get();


        //return all Suppliers
        if ($request->ajax()) {
//            dd('ddd');

            return DataTables::of($datas)

                ->addColumn('placeholder', '&nbsp;')

                ->editColumn('created_at', function ($data) {
                    return date('Y/m/d',strtotime($data->created_at));
                })
                ->editColumn('creditor_rl', function ($data) {
                    if ($data->creditor_rl){
                        return $data->creditor_rl->name_ar;
                    }else{
                        return '';
                    }
                })
                ->editColumn('value', function ($data) {
                    return $data->value . 'ر.س';
                })
                ->editColumn('image', function ($data) {
                    return '<img src="'.get_file($data->image).'" class=" rounded" style="height:50px;width:50px"
                             onclick="window.open(this.src)">';
                })
                ->editColumn('debit_rl', function ($data) {
                    if ($data->debit_rl){
                        return $data->debit_rl->name_ar;
                    }else{
                        return '';
                    }
                })


//                ->addColumn('delete_all', function ($data) {
//                    return "<input type='checkbox' class=' delete-all' data-tablesaw-checkall name='delete_all' id='" . $client->id . "'>";
//                })
                ->addColumn('actions', function ($data) {
                    if ($data->is_confirmed == 'new'){
                        $html = "
                    <a href='".route('receipt.show',$data->id)."'  class='btn mb-2 btn-warning' id='" . $data->id . "'> <i class='fa fa-eye'></i></a>
                    <a href='".route('receipt.edit',$data->id)."' class='btn mb-2 btn-info' id='" . $data->id . "'> <i class='fa fa-edit'></i></a>
                     <form  method='post' action='".route('receipt.destroy', $data->id)."'>
                                <input type='hidden' name='_method' value='DELETE'>
                                <input type='hidden' name='_token' value='".csrf_token()."'>
                                <button  style='float:right; margin:1px;' class='btn mb-2 btn-danger ' type='submit' id='" . $data->id . "'><i class='fa fa-trash'></i> </button>
                    </form>
                        ";
                    }else{
                        $html = "
                    <a href='".route('receipt.show',$data->id)."'  class='btn mb-2 btn-warning' id='" . $data->id . "'> <i class='fa fa-eye'></i></a>
                    ";
                    }

                    return $html;
                })
                ->rawColumns(['actions','placeholder','created_at','debit_rl','image','value','creditor_rl'])->make(true);



        }
        return view('admin.Finances.receipt.index');


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $bank_accounts = Account::FilterForPurchases(65)->get();

        $box_accounts = Account::FilterForPurchases(64)->get();

            $returnHTML = view("admin.Finances.receipt.parts.add_form")
                ->with([
                    'madins' =>  Account::where('parent_id', '!=' ,null)->get(),
                    'box_accounts' => $box_accounts,
                    'bank_accounts' => $bank_accounts,

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
        $data = $this->validate($request,[
            'date'=>'required',
            'creditor_id'=>'required',
            'value'=>'required',
            'type'=>'required',
            'payment_type'=>'required',
            'statement'=>'nullable',
            'image'=>'nullable',
        ]);

        $data['user_id'] = auth()->user()->id;

        if ($request->payment_type == 'check'){

            $data['check_number'] = $request->check_number;

            $data['debit_id'] = $request->bank_id;

            $data['check_date'] = $request->check_date;


        }elseif('cash'){
            $data['debit_id'] = $request->box_id;
        }




        if ($request->hasFile('image')){
            $data ['image'] = $this->uploadFiles('bond',$request->file('image'),null );
        }
         Bond::create($data);

        toastr()->success('تم الحفظ بنجاح');

        return redirect()->route('receipt.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {


        $bank_accounts = Account::FilterForPurchases(65)->get();

        $box_accounts = Account::FilterForPurchases(64)->get();
        $find = Bond::with('creditor_rl','debit_rl')->findOrFail($id);
            $returnHTML = view("admin.Finances.receipt.parts.show")
                ->with([
                    'madins' =>  Account::where('parent_id', '!=' ,null)->get(),
                    'box_accounts' => $box_accounts,
                    'bank_accounts' => $bank_accounts,
                    'find' => $find,

                ])
                ->render();
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

        $bank_accounts = Account::FilterForPurchases(65)->get();

        $box_accounts = Account::FilterForPurchases(64)->get();

        $find = Bond::with('creditor_rl','debit_rl')->findOrFail($id);

        if ($find->is_confirmed != 'new'){
            toastr()->warning('لا يمكن التعديل');
            return  back();
        }


            $returnHTML = view("admin.Finances.receipt.parts.edit_form")
                ->with([
                    'madins' =>  Account::where('parent_id', '!=' ,null)->get(),
                    'box_accounts' => $box_accounts,
                    'bank_accounts' => $bank_accounts,
                    'find' => $find,
                ])
                ->render();

        return $returnHTML;
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
        $data = $this->validate($request,[
            'date'=>'required',
            'creditor_id'=>'required',
            'value'=>'required',
            'type'=>'required',
            'payment_type'=>'required',
            'statement'=>'nullable',
            'image'=>'nullable',
        ]);

        if ($request->payment_type == 'check'){

            $data['check_number'] = $request->check_number;

            $data['debit_id'] = $request->bank_id;

            $data['check_date'] = $request->check_date;


        }else{
            $data['debit_id'] = $request->box_id;


        }

        if ($request->hasFile('image')){
            $data ['image'] = $this->uploadFiles('bond',$request->file('image'),null );
        }
        Bond::findOrFail($id)->update($data);

        //log activities

        toastr()->success('تم الحفظ بنجاح');

        return redirect()->route('receipt.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Bond::destroy($id);

        toastr()->info('تم الحذف');

        return redirect()->route('receipt.index');
    }
    public function print($id){

        $find = Bond::with('creditor_rl','debit_rl')->findOrFail($id);

        $printsetting = PrintSetting::first();


        return view('admin.Finances.receipt.print',compact('find','printsetting'));
    }//end fun
}
