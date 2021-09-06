<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SaleBill;
use App\Models\ReturnPurchaseBill;

class UsersReport extends Controller
{
    public function list_movements($user_id, $paginationVal,Request $request){
        
        $bills = SaleBill::where('user_id', $user_id)
                                ->Paginate($paginationVal);
        
        $returns = ReturnPurchaseBill::where('user_id', $user_id)
                                ->Paginate($paginationVal); 
        //$all_data = 
        
        if(isset($request)){
            if(isset($request->date_from) && isset($request->date_to)){
                $items = SaleBillItem::select("*", DB::raw('count(*) as items_count'))
                                ->with('item')
                                ->having('items_count', '>', '0')
                                ->whereBetween('created_at', [$request->date_from,$request->date_to])
                                ->groupBy('item_id')
                                ->orderBy('items_count', 'DESC')
                                ->Paginate($paginationVal);
                
            }else{
                $items = SaleBillItem::select("*", DB::raw('count(*) as items_count'))
                                ->with('item')
                                ->having('items_count', '>', '0')
                                ->groupBy('item_id')
                                ->orderBy('items_count', 'DESC')
                                ->Paginate($paginationVal);
              }
        }else{  
            $items = SaleBillItem::select("*", DB::raw('count(*) as items_count'))
                                ->with('item')
                                ->having('items_count', '>', '0')
                                ->groupBy('item_id')
                                ->orderBy('items_count', 'DESC')
                                ->Paginate($paginationVal);
        }

        
        return view('admin.reports.most_sold_products',compact('items', 'paginationVal'));
    }
}
