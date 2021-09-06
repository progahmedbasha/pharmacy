<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Bond;
use App\Models\PurchaseBill;
use App\Models\ReturnPurchaseBill;
use App\Models\ReturnSaleBill;
use App\Models\SaleBill;
use App\Models\TreeAccount;
use App\Models\User;
use Illuminate\Http\Request;

class AdminCloseReportTodayController extends Controller
{
    public function index(Request $request){
        $users = User::latest()->get();
        if ($request->has('_token')){

            if($request->type == "allUsers"){
                $sale = SaleBill::whereDate("created_at",$request->day)->sum('total_final');
                $saleBack = ReturnSaleBill::whereDate("created_at",$request->day)->sum('total_before_tax');
                $purchases = PurchaseBill::whereDate("created_at",$request->day)->sum('total_final');//المصروفات
                $purchasesBack = ReturnPurchaseBill::whereDate("created_at",$request->day)->sum('total_before_tax');
                $receipt = Bond::where('type','normal_snd_alqabd')->whereDate("created_at",$request->day)->sum('value');
                $billsOfExchange = Bond::where('type','normal_snd_alsirf')->whereDate("created_at",$request->day)->sum('value');


                $BankBalance = TreeAccount::where('parent_id',65)->sum('balance');
                $BoxBalance = TreeAccount::where('parent_id',64)->sum('balance');

                $token = 'yes';

                return view('admin.Finances.CloseReportToday.index',compact('users','sale','saleBack'
                    ,'purchases','purchasesBack','receipt','billsOfExchange','BankBalance','BoxBalance','token','request'));

            }else{
                $sale = SaleBill::whereDate("created_at", $request->day)
                    ->where('user_id', $request->user)->sum('total_final');
                $saleBack = ReturnSaleBill::whereDate("created_at", $request->day)
                    ->where('user_id', $request->user)->sum('total_before_tax');
                $purchases = PurchaseBill::whereDate("created_at", $request->day)
                    ->where('user_id', $request->user)->sum('total_final');//المصروفات


                $purchasesBack = ReturnPurchaseBill::whereDate("created_at", $request->day)
                    ->where('user_id', $request->user)->sum('total_before_tax');
                $receipt = Bond::where('type', 'normal_snd_alqabd')->whereDate("created_at", $request->day)
                    ->where('user_id', $request->user)->sum('value');
                $billsOfExchange = Bond::where('type', 'normal_snd_alsirf')->whereDate("created_at", $request->day)
                    ->where('user_id', $request->user)->sum('value');

                $BankBalance = TreeAccount::where('parent_id',65)->sum('balance');
                $BoxBalance = TreeAccount::where('parent_id',64)->sum('balance');

                $token = 'yes';

                return view('admin.Finances.CloseReportToday.index',compact('users','sale','saleBack'
                    ,'purchases','purchasesBack','receipt','billsOfExchange','BankBalance','BoxBalance','token','request'));



            }


            return view('admin.Finances.CloseReportToday.index',compact('users'));
        }else{
            return view('admin.Finances.CloseReportToday.index',compact('users'));
        }
        return view('admin.Finances.CloseReportToday.index',compact('users'));
    }//end fun

    public function loadClosePrint(Request $request){
        $users = User::latest()->get();
        if($request->type == "allUsers"){
            $sale = SaleBill::whereDate("created_at",$request->day)->sum('total_final');
            $saleBack = ReturnSaleBill::whereDate("created_at",$request->day)->sum('total_before_tax');
            $purchases = PurchaseBill::whereDate("created_at",$request->day)->sum('total_final');//المصروفات
            $purchasesBack = ReturnPurchaseBill::whereDate("created_at",$request->day)->sum('total_before_tax');
            $receipt = Bond::where('type','normal_snd_alqabd')->whereDate("created_at",$request->day)->sum('value');
            $billsOfExchange = Bond::where('type','normal_snd_alsirf')->whereDate("created_at",$request->day)->sum('value');


            $BankBalance = TreeAccount::where('parent_id',65)->sum('balance');
            $BoxBalance = TreeAccount::where('parent_id',64)->sum('balance');

            $token = 'yes';

            return view('admin.Finances.CloseReportToday.print',compact('users','sale','saleBack'
                ,'purchases','purchasesBack','receipt','billsOfExchange','BankBalance','BoxBalance','token','request'));

        }else {

            $sale = SaleBill::whereDate("created_at", $request->day)
                ->where('user_id', $request->user)->sum('total_final');
            $saleBack = ReturnSaleBill::whereDate("created_at", $request->day)
                ->where('user_id', $request->user)->sum('total_before_tax');
            $purchases = PurchaseBill::whereDate("created_at", $request->day)
                ->where('user_id', $request->user)->sum('total_final');//المصروفات


            $purchasesBack = ReturnPurchaseBill::whereDate("created_at", $request->day)
                ->where('user_id', $request->user)->sum('total_before_tax');
            $receipt = Bond::where('type', 'normal_snd_alqabd')->whereDate("created_at", $request->day)
                ->where('user_id', $request->user)->sum('value');
            $billsOfExchange = Bond::where('type', 'normal_snd_alsirf')->whereDate("created_at", $request->day)
                ->where('user_id', $request->user)->sum('value');

            $BankBalance = TreeAccount::where('parent_id',65)->sum('balance');
            $BoxBalance = TreeAccount::where('parent_id',64)->sum('balance');

            $token = 'yes';

            return view('admin.Finances.CloseReportToday.print', compact('users', 'sale', 'saleBack'
                , 'purchases', 'purchasesBack', 'receipt', 'billsOfExchange', 'BankBalance', 'BoxBalance', 'token', 'request'));
        }
    }//end fun

}//end fun
