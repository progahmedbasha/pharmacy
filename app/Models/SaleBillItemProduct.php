<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleBillItemProduct extends Model
{
	public function product_date()
	{
   		return $this->hasOne('App\Models\ProductDate','id','product_date_id')->with('product');
	}
}
