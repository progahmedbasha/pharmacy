<?php

namespace App\Http\Controllers\Admin\Modules\Finances;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\ConstraintDetail;
use Illuminate\Http\Request;

class AdminAccountStatementController extends Controller
{
    public function Search(Request $request){
        if ($request->has('_token')){
            $maindata = $this->validate($request,[
                'account'=>'required',
            ]);

            $find = ConstraintDetail::orderby('id','DESC');


            if ($request->account != null) {


                $find->where('account_id',$request->account);
            }


            if ($request->ToDate == null){
                $ToDate = date('Y-m-d');
            }else{
                $ToDate = $request->ToDate;
            }


            if ($request->FromDate != null){

                $find->whereBetween('date',[$request->FromDate,$ToDate]);

            }



            if ($request->flexRadioDefault != 'all') $find->where('type',$request->flexRadioDefault);


            if ($find->count() == 0){

                return response()->json('error',200);
            }

            $out = '';

            foreach ($find->with('constraint_rl')->get() as $data){
                $value = $data->creditor_value - $data->debit_value;

                if ($data->constraint_rl->type == 'snd_alsirf'){
                    $type = 'سند صرف';
                }elseif ($data->constraint_rl->type == 'snd_alqabd'){
                    $type = 'سند قبض';
                }elseif ($data->constraint_rl->type == 'sales'){
                    $type = 'مبيعات';
                }elseif ($data->constraint_rl->type == 'back_sales'){
                    $type = 'مرتجعات';
                }elseif ($data->constraint_rl->type == 'purchases'){
                    $type = 'مشتريات';
                }elseif ($data->constraint_rl->type == 'back_purchases'){
                    $type = 'مردودات';
                }elseif ($data->constraint_rl->type == 'check_collection'){
                    $type = 'تحصيل شيك';
                }elseif ($data->constraint_rl->type == 'check_sirf'){
                    $type = 'تسديد شيك';
                }elseif ($data->constraint_rl->type == 'daily_constrain'){
                    $type = 'قيد يومى';
                }elseif ($data->constraint_rl->type == 'first_balance'){
                    $type = 'رصيد إفتتاحى';
                }else{
                    $type = 'ــ';
                }
                if ($value < 0 ){
                    $color = 'red';
                }else{
                    $color = 'black';
                }

                $out.='<tr>
                        <td>'.$data->date.'</td>
                        <td>'.$data->constraint_id.'</td>
                        <td>'.$type.'</td>
                        <td>'.$data->constraint_rl->sale_id.'</td>
                        <td>'.$data->statement.'</td>
                        <td>'.$data->debit_value.'</td>
                        <td>'.$data->creditor_value.'</td>
                        <td><h4 style="color: '.$color.'">'.$value.'</h4></td>
                        </tr>';
            }

            return response()->json($out,200);
        }else{

            $accountes = Account::whereDoesntHave('children_accounts')->get();

            return view('admin.modules.Finances.AccountStatement.index',compact('accountes'));

        }///end fun
    }//end fun

}//end class
