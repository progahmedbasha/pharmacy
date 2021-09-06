<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseBillProduct extends Model
{
	public function product_date()
	{
   		return $this->belongsTo('App\Models\ProductDate', 'product_id')->with('product');
	}

	public function bill(){
		return $this->belongsTo('App\Models\PurchaseBill', 'bill_id')->with('supplier')->with('user');
	}
}
