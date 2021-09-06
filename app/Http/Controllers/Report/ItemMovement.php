<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SaleBillItem;
use App\Models\ReturnSaleBill;
use App\Models\Item;

class ItemMovement extends Controller
{
    public function index($paginate_val, $item_id, Request $request)
    {
        $item_data = Item::with('category')->findOrFail($item_id);
        
        if(isset($request)){
            if(isset($request->date_from) && isset($request->date_to))
            {
                $sell_data = SaleBillItem::where('item_id', $item_id)
                                    ->whereBetween('created_at', [$request->date_from,$request->date_to])
                                    ->with([ 'bill.return_bills'])
                                    ->paginate($paginate_val);
            }
            else
            {
                $sell_data = SaleBillItem::where('item_id', $item_id)
                                        ->with([ 'bill.return_bills'])
                                        ->paginate($paginate_val);
            }
        }
        else
        {
            $sell_data = SaleBillItem::where('item_id', $item_id)
                                    ->with([ 'bill.return_bills'])
                                    ->paginate($paginate_val);
        }
        
        
        
        $output = [
            'item_data' => $item_data,
            'sell_data' => $sell_data,
            'paginationVal' => $paginate_val 
        ];
        
        return view('admin.reports.item_movement')->with($output);
    }
}
