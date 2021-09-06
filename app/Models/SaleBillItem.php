<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleBillItem extends Model
{

	public function bill_item_product()
	{
   		return $this->hasOne('App\Models\SaleBillItemProduct','sale_bill_item_id')->with('product_date');
	}

	public function item()
	{
   		return $this->belongsTo('App\Models\Item', 'item_id');
	}

    public function product_date()
    {
        return $this->belongsTo('App\Models\SaleBillItemProduct', 'id','sale_bill_item_id')->with('product_date');
    }

    public function bill()
    {
        return $this->belongsTo('App\Models\SaleBill', 'bill_id');
    }
}
