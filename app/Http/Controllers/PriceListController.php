<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\TaxSetting;
use Illuminate\Http\Request;
use App\Models\Price_list;
use App\Models\Price_list_item;
use App\Models\Employee;
use App\Models\Item;
use App\Models\SaleBill;
use App\Models\SaleBillItem;
use App\Http\Requests\PriceListRequest;
use App\Models\Product;
use App\Models\ProductDate;
use App\Models\SaleBillItemProduct;
use App\Models\AccountingEntry;

class PriceListController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $all_data = Price_list::with(['creator', 'employee'])->latest()->get();
        $all_price_list_count = Price_list::count();
        $all_price_list_total = Price_list::sum('total');
        $active_price_list_count = Price_list::where('expire_date' , '>=', date('Y-m-d'))->count();
        $expired_price_list_count = Price_list::where('expire_date' , '<', date('Y-m-d'))->count();

        $output = [
            'all_data'                  => $all_data,
            'all_price_list_count'      => $all_price_list_count,
            'all_price_list_total'      => $all_price_list_total,
            'active_price_list_count'   => $active_price_list_count,
            'expired_price_list_count'  => $expired_price_list_count

        ];

        return view('admin/sale/pricelist')->with($output);
    }

    public function create()
    {
        $employees = Employee::get();
        $items     = Item::get();

        $output = [
            'employees' => $employees,
            'items'     => $items
        ];
        $tax = TaxSetting::find(2);
        $customers = Customer::where('type',0)->get();


        return view('admin/sale/create_price_list',compact('output','tax','customers'));
    }

    public function store(PriceListRequest $request)
    {
        //create price list
        $new_price_list = Price_list::create([
            'employee_id'       => $request->customer_id,
            'pricelist_number'  => $request->price_list_number,
            'date'              => $request->date,
            'expire_date'       => $request->expire_date,
            'total'             => $request->final_total,
            'created_by'        => auth()->user()->id
        ]);

        $items = $request->multi_product;
        $prices = $request->multi_price;
        $qties = $request->multi_amount ;

        foreach($items as $key=>$item_id)
        {
            //price list items
             Price_list_item::create([
                'price_list_id' => $new_price_list->id,
                'qty'           => $qties[$key],
                'price'         => $prices[$key],
                'item_id'       => $item_id
            ]);
        }

        return redirect()->route('pricelist')->with('success' , __('sale.success_msg'));
    }

    public function details($id)
    {
        $details = Price_list::with(['employee', 'items.item_details'])->findOrFail($id);
        //return $details;
        return view('admin/sale/price_details',compact('details'));
    }

    public function convert_to_sale_bill($id)
    {
        $details = Price_list::with(['employee', 'items.item_details'])->findOrFail($id);

        //create sale bill
        $bill = new SaleBill();
        $tax_data = TaxSetting::find(2);

        $all_items_price        = 0;
        $all_items_discount     = 0;
        $total_tax              = 0;
        $all_items_total_price  = 0;

        //calculate all products prices
        foreach ($details->items as $key => $product) {
            $item = Item::find($product->item_details->id);

            if ($product->item_details->isTax == 1) {
                $tax_value = round(($product->item_details->default_sale_price * $tax_data->tax_value) / 100, 2);
            } else {
                $tax_value = 0;
            }

            $item_discount              = $product->item_details->default_discount;
            $item_price                 = $product->item_details->default_sale_price - $item_discount;
            $item_total_price_after_tax = $product->item_details->default_sale_price + $tax_value ;

            $all_items_price       += $item_price;
            $all_items_discount    += $item_discount;
            $total_tax             += $tax_value;
            $all_items_total_price += $item_total_price_after_tax;
        }

        $bill->bill_number = 0;
        $bill->bill_date    = $details->date;
        $bill->customer_id = $details->employee_id;
        $bill->employee_id =  auth()->user()->id;
        $bill->total_before_tax = $all_items_price;
        $bill->total_tax =$total_tax;
        $bill->total_final = $all_items_total_price;
        $bill->due_date = $details->date;
        $bill->user_id = auth()->user()->id;

        $bill->is_paid = 0;
        $bill->remaining_amount = $all_items_total_price;

        $bill->save();
        $bill->bill_number = $bill->id;

        $bill->save();


        //insert bill items
        foreach ($details->items as $key => $product) {
            $item = Item::find($product->item_details->id);

            if($product->item_details->isTax == 1)
            {
                $tax_value = round(($product->item_details->default_sale_price * $tax_data->tax_value) / 100, 2);
            }
            else
            {
                $tax_value = 0;
            }
            $bill_pro = new SaleBillItem();
            $bill_pro->bill_id          = $bill->id;
            $bill_pro->item_id          = $product->item_details->id;
            $bill_pro->price            = $product->item_details->default_sale_price;
            $bill_pro->product_discount = $product->item_details->default_discount;
            $bill_pro->tax_value        = $tax_value;
            $bill_pro->quantity         = $product->qty;
            $bill_pro->total_price      = $product->item_details->default_sale_price + $tax_value;
            $bill_pro->save();

            if($product->item_details->type != 3){
                $quantity = $product->qty;
                $q = 0;
                $tot_entry_cost = 0;
                do{
                    $pro = Product::where('item_id',$product->item_details->id)->first();
                    $product_date = ProductDate::where('product_id',$pro->id)->where('quantity','!=',0)->first();

                    if($product_date) {
                        if ($product_date->quantity >= $quantity) {
                            $product_date->quantity = $product_date->quantity - $quantity;
                            $q = $quantity;
                            $quantity = 0;
                        } else {
                            $q = $product_date->quantity;
                            $quantity -= $q;
                            $product_date->quantity = 0;
                        }

                        $product_date->save();


                        $sale_pro = new SaleBillItemProduct();
                        $sale_pro->sale_bill_item_id = $bill_pro->id;
                        $sale_pro->product_date_id = $product_date->id;
                        $sale_pro->quantity = $q;
                        $sale_pro->save();

                        $tot_entry_cost += ($product_date->cost * $q);
                    }
                    else
                        $quantity = 0;
                }while($quantity > 0);
            }
        }

        //delete  pricelist items
        Price_list_item::where('price_list_id', $details->id)->delete();

        //delete pricelist
        $details->delete();

        return redirect()->route('salebilldetail', $bill->id);


    }
}
