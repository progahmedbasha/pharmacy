<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDate extends Model
{
	//protected $appends =['total_cost'];

	protected $fillable = [
        'quantity'
    ];

	public function store()
	{
   		return $this->belongsTo('App\Models\Store', 'store_id');
	}

	public function product()
	{
   		return $this->belongsTo('App\Models\Product', 'product_id')->with('item');
	}

	public function purchase_bill_product(){
		return $this->hasOne('App\Models\PurchaseBillProduct','product_id')->with('bill');
	}

	/*public function getTotalCostAttribute($value) {
		return $this->cost * $this->quantity;
    }*/
}
