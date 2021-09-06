<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class ReturnPurchaseProduct extends Model
{
	public function return_bill()
	{
   		return $this->belongsTo('App\Models\ReturnPurchaseBill','return_id');
	}

	public function bill_products()
	{
   		return $this->belongsTo('App\Models\PurchaseBillProduct','bill_product_id')->with('product_date');
	}
}
