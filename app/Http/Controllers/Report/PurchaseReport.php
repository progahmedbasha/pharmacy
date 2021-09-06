<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseBill;

class PurchaseReport extends Controller
{
    public function show_all_bills($paginationVal,Request $request){

        $total_final = PurchaseBill::sum('total_final');
        $paid_amount = 0;
        $remaining_amount = PurchaseBill::
        whereHas('supplier' , function($q) { $q->where('type',1);})
        ->sum('remaining_amount');

        if(isset($request)){
            if(isset($request->search_val)){
              $search = $request->search_val;
              $bills = PurchaseBill::with('user')->with('supplier')->
               where('bill_number', $request->search_val)->paginate(100);
            }else if(isset($request->date_from) && isset($request->date_to)){
                $bills = PurchaseBill::with('user')->with('supplier')->
                whereBetween(DB::raw('DATE(created_at)'), [$request->date_from,$request->date_to])->paginate(100);
            }else{
                $bills = PurchaseBill::with('user')->with('supplier')->paginate($paginationVal);
              }
        }else{  
            $bills = PurchaseBill::with('user')->with('bill_payments')->with('supplier')->paginate($paginationVal);
        }

        $report_page = true;
        
        return view('admin.purchase.purchasemanagebill',compact('bills' , 'paginationVal' ,'total_final','paid_amount', 'remaining_amount', 'report_page'));
    }
}
