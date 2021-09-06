<?php

namespace App\Http\Controllers;

use App\Models\AccountingEntry;
use Illuminate\Http\Request;

use Session;

use App\Models\Store;
use App\Models\Department;

use App\Models\Item;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\ProductDate;
use App\Models\TreeAccount;
use App\Models\StoreClassification;
use App\Models\EntryAction;

class StoreController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }

  ////////////////////////// stores ////////////////////////////////////////

  public function show_all_stores($paginationVal,Request $request){
    $stores = Store::whenSearch($request->search)->with('department')->with('main_store')->paginate($paginationVal);
    return view('admin.store.storemanage',compact('stores','paginationVal'));
  }

  public function add_store_page(){
    $department = Department::all();
    $classify = StoreClassification::all();
    $main_store = Store::where('store_type',0)->get();
    $stores  = '';
    return view('admin.store.addstore',compact('main_store','department', 'classify','stores'));
  }

  public function add_new_store(Request $request){

    $classify = StoreClassification::find($request->store_classify);
    $acc = TreeAccount::where('id',$classify->tree_id)->with('account')->first();
    $code = ($acc->id_code.'0000')+count($acc->account) + 1;

    $store = new Store();
    $store->store_name_en = $request->store_name_en;
    $store->store_name_ar = $request->store_name_ar;
    $store->store_code = "st";
    $store->address = $request->store_address;
    $store->city = $request->store_city;
    $store->area = $request->store_area;
    $store->classify_id = $request->store_classify;
    $store->store_type = $request->store_type;
    if($request->store_type == 1)
      $store->store_parent_id = $request->main_store;
    $store->department_id = $request->store_dept;

    $store->save();
    $st = "";
    if($store->id < 9) $st = "st000";
    else if($store->id < 100 ) $st = "st00";
    else if($store->id < 1000 ) $st = "st0";
    $store->store_code = $st.$store->id;
    $store->save();

    $account = new TreeAccount;
    $account->name_ar = $request->store_name_ar;
    $account->name_en = $request->store_name_en;
    $account->account_type = 1;
    $account->parent_id = $classify->tree_id;
    $account->balance_type = 1;
    $account->user_id = auth()->user()->id;
    $account->final_account_id = 1;
    $account->id_code = $code;
    $store->tree()->save($account);

    Session::flash('success', 'تمت العملية بنجاح!');
    return redirect()->route('storemanage');
  }

  public function show_store_detail($id){
    $stdetail = Store::where('id',$id)->with('department')->with('main_store')->first();
    return view('admin.store.storedetail', compact('stdetail'));
  }

  public function edit_store_page($id){
    $stdetail = Store::where('id',$id)->with('department')->with('main_store')->first();
    return view('admin.store.editstore',compact('id', 'stdetail'));
  }

  public function edit_store(Request $request){
    //return $request;
    $store = Store::find($request->store_id);
    $store->store_name_en = $request->store_name_en;
    $store->store_name_ar = $request->store_name_ar;
    $store->address = $request->store_address;
    $store->city = $request->store_city;
    $store->area = $request->store_area;
    $store->save();
    Session::flash('success', 'تمت العملية بنجاح!');
    return redirect()->route('storedetail',['id' => $request->store_id]);
  }

  /////////////////////////////////////// products //////////////////////////////////////////////

  public function show_all_products($paginationVal,Request $request){
    //$pros = Item::with('product')->get();
    //$total_quantity = $pros->sum('product.total_quantity');
    //$total_avg_cost = round($pros->sum('product.avg_cost'),2);

    //return $request;
    $total_quantity = ProductDate::sum('quantity');
    $total_avg_cost = 0;
    $total_sale_price = Item::sum('default_sale_price');
    //return $request;
    if(isset($request)){
    if(isset($request->search_val)){
      $search = $request->search_val;
       $products = Item::with('product')->
       whereHas('product' , function($q) use($search) {
        $q->where('barcode',$search);
       })->
       orWhere('name_en','LIKE', '%' . $request->search_val . '%')->
       orWhere('name_ar','LIKE', '%' . $request->search_val . '%')->paginate(100);
    }else{
     $products = Item::with('product')->paginate($paginationVal);
    }
    }else{
	   $products = Item::with('product')->paginate($paginationVal);
    }
    //return $products[0]->product->total_quantity;
    return view('admin.store.productservice',compact('products', 'paginationVal','total_quantity','total_avg_cost','total_sale_price'));
  }

  public function add_product_page(){
    $categories = Category::whereNull('parent_id')->with('sup_category')->get();
    $main_stores = Store::where('store_type',0)->get();
   // dd($main_stores);
    $stores = Store::all();
    $pro_types = ProductType::all();
   // dd($stores);
    return view('admin.store.addproduct',compact('categories','pro_types','stores','main_stores'));
  }

  public function add_new_product(Request $request){
   /* $this->validate($request, [
        'sub_category' => 'required',
      ]);*/

    if($request->item_type == 3){
      $this->validate($request, [
        'sub_category' => 'required',
      ]);
	  }else if(($request->item_type == 1 || $request->item_type == 2) && (isset($request->active_multi_val) && $request->active_multi_val == 1)){
      $this->validate($request, [
	     'sub_category' => 'required',
      //  'defaultprice_purchase' => 'required',
        'base_store' => 'required',
      //  'sku_code' => 'required|unique:products,SKU_code',
        'barcode' => 'required|unique:products,barcode',
      //  'stock_limit_alarm' => 'required',
     //   'react_material_en' => 'required',
    //    'react_material_ar' => 'required',
      //  'concentrate' => 'required',
        'pro_type' => 'required',
        'base_amount' => 'required',
        //'defaultprice_purchase' => 'required',

        'multi_production_date' => 'required|min:1',
        'multi_expire_date' => 'required',
        'multi_amount' => 'required',
        'multi_price' => 'required',
        'multi_store' => 'required',
      ],[
    		'defaultprice_purchase.required' => 'this field is required',
    		'base_store.required' => 'this field is required',
    		'sku_code.required' => 'this field is required',
    		'stock_limit_alarm.required' => 'this field is required',
    		'react_material_en.required' => 'this field is required',
    		'react_material_ar.required' => 'this field is required',
    		'concentrate.required' => 'this field is required',
    		'pro_type.required' => 'this field is required',
    		'base_amount.required' => 'this field is required',
    		'defaultprice_purchase.required' => 'this field is required',
    		]);

      }else{
        $this->validate($request, [
	      'sub_category' => 'required',
        'defaultprice_purchase' => 'required',
        'base_store' => 'required',
        'sku_code' => 'required|unique:products,SKU_code',
        'stock_limit_alarm' => 'required',
        'react_material_en' => 'required',
        'react_material_ar' => 'required',
        'concentrate' => 'required',
        'pro_type' => 'required',
        'base_amount' => 'required',
        'defaultprice_purchase' => 'required',

        'base_production_date' => 'required',
        'base_expire_date' => 'required',
        ],[
    		'defaultprice_purchase.required' => 'this field is required',
    		'base_store.required' => 'this field is required',
    		'sku_code.required' => 'this field is required',
    		'stock_limit_alarm.required' => 'this field is required',
    		'react_material_en.required' => 'this field is required',
    		'react_material_ar.required' => 'this field is required',
    		'concentrate.required' => 'this field is required',
    		'pro_type.required' => 'this field is required',
    		'base_amount.required' => 'this field is required',
    		'defaultprice_purchase.required' => 'this field is required',
	  ]);

    }

    //return $request;

    $item = new Item();
    $item->code = "10000";
    $item->name_en = $request->item_name_en;
    $item->name_ar = $request->item_name_ar;
    $item->default_sale_price = $request->defaultprice_sale;
    $item->sub_category_id = $request->sub_category;
    $item->type = $request->item_type;
    $item->isTax = $request->tax_type;
    $item->default_discount = $request->default_discount;
    $item->user_id = auth()->user()->id;
    $item->save();
    $item->code = $item->code + $item->id;
    $item->save();

    if($request->item_type == 1 || $request->item_type == 2){

      $product = new Product();
      $product->item_id = $item->id;
      $product->default_buy_price = $request->defaultprice_purchase;
      $product->default_store_id = $request->base_store;
      $product->SKU_code = $request->sku_code;
      $product->barcode = $request->barcode;
      $product->stock_limit = $request->stock_limit_alarm;
      $product->track_type = $request->stock_tracking;
      $product->react_material_en = $request->react_material_en;
      $product->react_material_ar = $request->react_material_ar;
      $product->concentrate = $request->concentrate;
      $product->product_type_id = $request->pro_type;

      $product->save();

      if(isset($request->active_multi_val) && $request->active_multi_val == 1){
        foreach ($request->multi_production_date as $key => $value) {
          if($value != null){
            $pro_date = new ProductDate();
            $pro_date->product_id = $product->id;
            $pro_date->production_date = $value;
            $pro_date->expire_date = ($request->multi_expire_date)[$key];
            $pro_date->quantity = ($request->multi_amount)[$key];
            $pro_date->cost = ($request->multi_price)[$key];
            $pro_date->store_id = ($request->multi_store)[$key];
            $pro_date->note = ($request->multi_notes)[$key];
            $pro_date->save();
          }
        }
      }else{
        $pro_date = new ProductDate();
        $pro_date->product_id = $product->id;
        $pro_date->production_date = $request->base_production_date;
        $pro_date->expire_date = $request->base_expire_date;
        $pro_date->quantity = $request->base_amount;
        $pro_date->cost = $request->defaultprice_purchase;
        $pro_date->store_id = $request->base_store;
        $pro_date->note = $request->base_note;
        $pro_date->save();
      }
    }
    Session::flash('success', 'تمت العملية بنجاح!');
    return redirect()->route('productservice',['paginationVal' => 10]);
  }

  public function edit_product_page($id){
	 $item = Item::where('id' , $id)->with('product')->first();
	 //return $item;
    $categories = Category::whereNull('parent_id')->with('sup_category')->get();
    $main_stores = Store::where('store_type',0)->get();
    $stores = Store::all();
    $pro_types = ProductType::all();
    return view('admin.store.editproduct',compact('categories','pro_types','stores','main_stores','item'));
  }

  public function edit_product(Request $request){

    if($request->item_type == 1 || $request->item_type == 2) {
        $this->validate($request, [
        'defaultprice_purchase' => 'required',
        'base_store' => 'required',
        'stock_limit_alarm' => 'required',
        'pro_type' => 'required',
        'defaultprice_purchase' => 'required',

        ],[
    		'defaultprice_purchase.required' => 'this field is required',
    		'base_store.required' => 'this field is required',
    		'stock_limit_alarm.required' => 'this field is required',
    		'pro_type.required' => 'this field is required',
    		'defaultprice_purchase.required' => 'this field is required',
	  ]);

    }

    //return $request;

    $item = Item::find($request->item_id);
    $item->name_en = $request->item_name_en;
    $item->name_ar = $request->item_name_ar;
    $item->default_sale_price = $request->defaultprice_sale;
    $item->default_discount = $request->default_discount;
    $item->isTax = $request->tax_type;
    $item->save();

    if($item->type == 1 || $item->type == 2){
      $product = Product::find($request->product_id);
      $product->item_id = $item->id;
      $product->default_buy_price = $request->defaultprice_purchase;
      $product->default_store_id = $request->base_store;
      $product->stock_limit = $request->stock_limit_alarm;
      $product->track_type = $request->stock_tracking;
      $product->product_type_id = $request->pro_type;
      $product->save();

    }
    Session::flash('success', 'تمت العملية بنجاح!');
    return redirect()->route('productdetail',['id' => $item->id]);
  }

  public function show_product_detail($id){
    $product = Item::where('id',$id)->with('product')->with('category')->with('user')->first();
    $stores = Store::all();
    //return $product;
    return view('admin.store.productdetail',compact('product','stores'));
  }

  public function add_new_stock(Request $request){
    $pro_date = new ProductDate();
    $pro_date->product_id = $request->product_id;
    $pro_date->production_date = $request->production_date;
    $pro_date->expire_date = $request->expiration_date;
    $pro_date->quantity = $request->amount;
    $pro_date->store_id = $request->store_id;
    $pro_date->note = $request->notes;
    $pro_date->cost = $request->buy_price;
    $pro_date->save();

    return redirect()->back();
  }

  public function edit_stock(Request $request){
    $pro_date = ProductDate::find($request->stock_id);
    $pro_date->production_date = $request->production_date;
    $pro_date->expire_date = $request->expiration_date;
    $pro_date->quantity = $request->quantity;
    $pro_date->note = $request->notes;
    $pro_date->cost = $request->buy_price;
    $pro_date->save();

    Session::flash('success', 'تمت العملية بنجاح!');
    return redirect()->back();
  }

  public function barcode_list($lang){
    $products = Item::where('type',1)->orWhere('type',2)->with('product')->get();
   // return ($products);
    return view('admin.store.barcodelist',compact('products', 'lang'));
  }

  public function barcode_single($id, $lang){
    $product = Item::where('id',$id)->with('product')->first();
   // return ($products);
    return view('admin.store.barcodesingle',compact('product' , 'lang'));
  }

/////////////////////// Inventory /////////////////////////

  public function show_inventory_products(Request $request){

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

      //$products = Item::with('product')->where('type','!=',3)->paginate(50);

    return view('admin.store.inventorylist',compact('products', 'stores'));
  }

  public function product_inventory($product_id)
  {
      $product_data = Item::with('product')->findOrFail($product_id);

      return view('admin.store.inventory_item', compact('product_data'));
  }

  public function check_product_qty_ajax(Request $request)
  {
      $qty_dif  = $request->current_qty - $request->system_qty;
      $creditor = 0;
      $debit    = 0;

      $product_data = Item::where('id', $request->product_id)->first();

      if($qty_dif > 0)
      {
          //debit -- مدين
          $debit = $qty_dif;

          $account = TreeAccount::find(130);
          $account_balance = $account->balance + $debit;

          //update account balance
          $account->update(['balance'=> $account_balance]);

          $entry = AccountingEntry::create([
              'type'=> 1,
              'title_en' => 'Stocktaking',
              'title_ar'=> 'جرد المخازن',
              'date' => date('Y/m/d'),
              'user_id'     => auth()->user()->id
                ]);

          EntryAction::create([
              'entry_id' => $entry->id,
              'tree_id'  => 130,
              'credit'   => 0,
              'debit'    => $product_data->default_sale_price * $qty_dif,
          ]);

      }
      elseif($qty_dif < 0)
      {
          //credit -- دائن
          $creditor = abs($qty_dif);

          $entry = AccountingEntry::create([
              'title_en'    => 'Stocktaking',
              'title_ar'    => 'جرد المخازن',
              'date'        => date('Y/m/d'),
              'user_id'     => auth()->user()->id
          ]);

          $account = TreeAccount::find(130);
          $account_balance = $account->balance - $creditor;

          //update account balance
          $account->update(['balance'=> $account_balance]);


          EntryAction::create([
              'entry_id' => $entry->id,
              'tree_id'  => 130,
              'credit'   => $product_data->default_sale_price * $creditor,
              'debit'    => 0,
              'balance'  => $account_balance
          ]);
      }

      //update system qty
      ProductDate::where('product_id', $request->product_id)->update(['quantity'=>0]);
      $date_data = ProductDate::where('product_id', $request->product_id)->first();
      $date_data->update(['quantity'=>$request->current_qty]);

      toastr()->success('تم التحديث بنجاح');
      return redirect()->back();
  }

  /////////////////////// Definitions /////////////////////////

  public function show_all_definitions(){
    $categories = Category::whereNull('parent_id')->get();
    $sub_categories = Category::whereNotNull('parent_id')->with('main')->get();
    $pro_types = ProductType::all();

    return view('admin.store.productdefinition',compact('categories','sub_categories','pro_types'));
  }

  public function add_new_category(Request $request){
    $category = new Category();
    $category->category_en = $request->cat_en;
    $category->category_ar = $request->cat_ar;
    if(isset($request->cat_val))
      $category->parent_id = $request->cat_val;
    $category->save();

    return redirect()->back();
  }

  public function add_new_type(Request $request){
    $type = new ProductType();
    $type->type_en = $request->type_en;
    $type->type_ar = $request->type_ar;
    $type->save();

    return redirect()->back();
  }

}
