<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Bond;
use App\Models\EntryAction;
use App\Models\PurchaseBill;
use App\Models\ReturnPurchaseBill;
use App\Models\ReturnSaleBill;
use App\Models\SaleBill;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminProfitController extends Controller
{
    public function index(Request $request){
        $users = User::latest()->get();
        if ($request->has('_token')){


            $sale = SaleBill::whereBetween(DB::raw('DATE(created_at)'), [$request->from,$request->to])->sum('total_final');
            $expenses = EntryAction::whereBetween(DB::raw('DATE(created_at)'), [$request->from,$request->to])->where('tree_id',4)->sum('debit');
            $saleBack = ReturnSaleBill::whereBetween(DB::raw('DATE(created_at)'), [$request->from,$request->to])->sum('total_before_tax');
            $discount = SaleBill::whereBetween(DB::raw('DATE(created_at)'), [$request->from,$request->to])->sum('total_discount');

            $total = EntryAction::whereBetween(DB::raw('DATE(created_at)'), [$request->from,$request->to])->where('tree_id',4)->sum('debit')

                -
                EntryAction::whereBetween(DB::raw('DATE(created_at)'), [$request->from,$request->to])->where('tree_id',4)->sum('credit');

                $token = 'yes';

                return view('admin.Finances.Profit.index',compact('users','sale','saleBack','discount','expenses','total','token','request'));




        }else{
            return view('admin.Finances.Profit.index',compact('users'));
        }
        return view('admin.Finances.Profit.index',compact('users'));
    }//end fun

    public function profitPrint(Request $request){
        $users = User::latest()->get();

        $sale = SaleBill::whereBetween(DB::raw('DATE(created_at)'), [$request->from,$request->to])->sum('total_final');
        $expenses = EntryAction::whereBetween(DB::raw('DATE(created_at)'), [$request->from,$request->to])->where('tree_id',4)->sum('debit');
        $saleBack = ReturnSaleBill::whereBetween(DB::raw('DATE(created_at)'), [$request->from,$request->to])->sum('total_before_tax');
        $discount = SaleBill::whereBetween(DB::raw('DATE(created_at)'), [$request->from,$request->to])->sum('total_discount');

        $total = EntryAction::whereBetween(DB::raw('DATE(created_at)'), [$request->from,$request->to])->where('tree_id',4)->sum('debit')

            -
            EntryAction::whereBetween(DB::raw('DATE(created_at)'), [$request->from,$request->to])->where('tree_id',4)->sum('credit');

        $token = 'yes';

        return view('admin.Finances.Profit.print',compact('users','sale','saleBack','discount','expenses','total','token','request'));

    }//end fun

}
