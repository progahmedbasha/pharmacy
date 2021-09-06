<?php

namespace App\Http\Controllers\Admin\Finances\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\LogActivityTrait;
use App\Models\Account;
use App\Models\ConstraintDetail;

class TrialBalanceController extends Controller
{
    //
    use LogActivityTrait;

    public function index()
    {
        return view('admin.Finances.Reports.trial_balance');
    }

    public function filter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'FromDate' => 'required',
            'ToDate' => 'required',
            'hideZeroAccounts' => 'required',
            'type' => 'required'
        ]);

        $output  = '';
        $message = '';
        $status  = 'yes';

        if ($validator->fails())
        {
            $status  = 'no';
            $message = 'من فضلك أدخل قيم الفلاتر';
        }
        else
        {
            $date_from = $request->FromDate;
            $date_to   = $request->ToDate;
            $show_first_period_balance = 0;
            $hide_zero_accounts = $request->hideZeroAccounts;
            $type = $request->type;

            if($type == 4) //latest level -- تفصيلي
            {
                //$accounts = Account::where('level', Account::max('level'))->get();
                $accounts = Account::whereDoesntHave('grand_children_accounts')->get();
            }
            else
            {
                $accounts =  Account::where('level', $type)
                            ->with('grand_children_accounts')->get();

            }

            //return $accounts_ids;

            //get day before , this will be the end of first period
            $end_of_first_period_date = date( 'Y-m-d', strtotime( $date_from . ' -1 day' ) );

            //totals initial values
            $first_period_debit_totals      = 0;
            $first_period_credit_totals     = 0;
            $specific_period_debit_totals   = 0;
            $specific_period_credit_totals  = 0;
            $all_accounts_total_debit       = 0;
            $all_accounts_total_credit      = 0;
            $total_debit_balance            = 0;
            $total_credit_balance           = 0;

            foreach($accounts as $account)
            {
                $credit_balance = 0;
                $debit_balance  = 0;

                $accounts_ids = collect([$account->id]);

                if($type != 4)
                {
                    //get account childs
                    $accounts_ids = collect([$account->id]);
                    $accounts_ids = $this->get_current_account_sub_accounts_ids($account->grand_children_accounts, $accounts_ids);
                    //return $accounts_ids;
                }


                //first period debit balance
                $first_period_debit_value = ConstraintDetail::whereIn('account_id', $accounts_ids)
                                            ->where('date', '<=', $end_of_first_period_date)
                                            ->sum('debit_value');

                //first period credit balance
                $first_period_credit_value = ConstraintDetail::whereIn('account_id', $accounts_ids)
                                            ->where('date', '<=', $end_of_first_period_date)
                                            ->sum('creditor_value');

                //debit value in this period
                $specific_period_debit_balance = ConstraintDetail::whereIn('account_id', $accounts_ids)
                                            ->whereBetween('date', [$date_from, $date_to])
                                            ->sum('debit_value');

                //credit value in this period
                $specific_period_credit_balance = ConstraintDetail::whereIn('account_id', $accounts_ids)
                                            ->whereBetween('date', [$date_from, $date_to])
                                            ->sum('creditor_value');



                //total debit
                $account_total_debit =  $first_period_debit_value + $specific_period_debit_balance;

                //total credit
                $account_total_credit =  $first_period_credit_value + $specific_period_credit_balance;

                if($hide_zero_accounts == 0 || ( $hide_zero_accounts == 1 && ($first_period_debit_value != 0
                                                || $first_period_credit_value != 0
                                                || $specific_period_debit_balance != 0
                                                || $specific_period_credit_balance != 0
                                                ))
                                                )
                {

                //account type
                $account_type = $account->account_type=='debit' ? 'مدين' : 'دائن';

                //debit balance
                if($account->account_type == 'debit')
                {
                    $debit_balance = $account_total_debit - $account_total_credit;
                    if($debit_balance < 0)
                    {
                        $credit_balance = abs($debit_balance);
                        $debit_balance  = 0;

                    }
                }
                else
                {
                    $credit_balance = $account_total_credit - $account_total_debit;
                    if($credit_balance < 0)
                    {
                        $debit_balance  = abs($credit_balance);
                        $credit_balance = 0;
                    }
                }

                $output .= '<tr>
                                <td>'.$account->code.'</td>
                                <td>'.$account->name.'</td>
                                <td>'.$account_type.'</td>';
                 if($show_first_period_balance == 1)
                 {
                    $output .= '<td>'.$first_period_debit_value.'</td>
                                <td>'.$first_period_credit_value.'</td>';
                 }

                 $output .=    '<td>'.$specific_period_debit_balance.'</td>
                                <td>'.$specific_period_credit_balance.'</td>
                                <td>'.$account_total_debit.'</td>
                                <td>'.$account_total_credit.'</td>
                                <td>'.$debit_balance.'</td>
                                <td>'.$credit_balance.'</td>
                            </tr>';
                 }

                $first_period_debit_totals += $first_period_debit_value;
                $first_period_credit_totals += $first_period_credit_value;
                $specific_period_debit_totals += $specific_period_debit_balance;
                $specific_period_credit_totals += $specific_period_credit_balance;
                $all_accounts_total_debit += $account_total_debit;
                $all_accounts_total_credit += $account_total_credit;
                $total_debit_balance += $debit_balance;
                $total_credit_balance += $credit_balance;
            }

            //totals
            $output .= '<tr>
                            <td colspan="3">الإجمالى</td>';
            if($show_first_period_balance == 1){
                $output .= '<td>'.$first_period_debit_totals.'</td>
                            <td>'.$first_period_credit_totals.'</td>';
            }
            $output .= '    <td>'.$specific_period_debit_totals.'</td>
                            <td>'.$specific_period_credit_totals.'</td>
                            <td>'.$all_accounts_total_debit.'</td>
                            <td>'.$all_accounts_total_credit.'</td>
                            <td>'.$total_debit_balance.'</td>
                            <td>'.$total_credit_balance.'</td>
                        </tr>';

            //difs
            $output .= '<tr>
                            <td colspan="3">الفارق</td>';
            if($show_first_period_balance == 1){
                $first_period_dif = $first_period_debit_totals - $first_period_credit_totals;

                $output .= '<td colspan="2" class="text-center">'.$first_period_dif.'</td>';
            }

            $specific_period_totals_dif = $specific_period_debit_totals - $specific_period_credit_totals;
            $all_accounts_total_dif     = $all_accounts_total_debit - $all_accounts_total_credit;
            $total_balances_dif         = $total_debit_balance - $total_credit_balance;

            $output .= '    <td colspan ="2" class="text-center">'.$specific_period_totals_dif.'</td>
                            <td colspan="2" class="text-center">'.$all_accounts_total_dif.'</td>
                            <td colspan="2" class="text-center">'.$total_balances_dif.'</td>
                        </tr>';

        }

        return response()->json(['status'=>$status, 'data'=>$output, 'message' => $message ]);
    }

    public function get_current_account_sub_accounts_ids($accounts, $childs_ids)
    {
        foreach($accounts as $account)
        {
            $childs_ids->push($account->id);

            if(count($account->grand_children_accounts) != 0)
            {
                $this->get_current_account_sub_accounts_ids($account->grand_children_accounts, $childs_ids);
            }

        }

        return $childs_ids;
    }

}
