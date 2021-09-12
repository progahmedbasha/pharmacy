<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Store;
use App\Models\Item;
class InventoryReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventory = Inventory::with('store')->get();
        $stores = Store::all();
        return view('admin.reports.showinventorylist',compact('inventory','stores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inventory = new Inventory();
            $inventory->store_id = $request->store_id;
        
            $inventory->save();
        
        // $data = Inventory::where('id', $inventory->id)->with('store')->get();
        
        // return redirect('x/{$inventory->id}');



            $stores = Store::get(['id', 'store_name_ar']);

      if(isset($request))
      {
          if(isset($request->store_id) && $request->store_id != 0)
          {
              $products_data = Item::
                  whereHas('product', function($q) use ($request){
                      return $q->where('default_store_id', $request->store_id);
                  })
                  ->where('type','!=',3);

          }
          else
          {
              $products_data = Item::
              whereHas('product')
                  ->where('type','!=',3);
          }

          $products = $products_data->paginate(50);

      }
        return view('admin.store.inventorylist',compact('products','stores'));
    }
 

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
    public function inventory($store_id,Request $request)
    {
        
    //     $stores = Store::get(['id', 'store_name_ar']);

    //   if(isset($request))
    //   {
    //       if(isset($request->store_id) && $request->store_id != 0)
    //       {
    //           $products_data = Item::
    //               whereHas('product', function($q) use ($request){
    //                   return $q->where('default_store_id', $request->store_id);
    //               })
    //               ->where('type','!=',3);

    //       }
    //       else
    //       {
    //           $products_data = Item::
    //           whereHas('product')
    //               ->where('type','!=',3);
    //       }

    //       $products = $products_data->paginate(50);

    //   }
    //   // return $products;
    //   //$products = Item::with('product')->where('type','!=',3)->paginate(50);

    // return view('admin.reports.inventoryshow',compact('products', 'stores'));

    }
}
