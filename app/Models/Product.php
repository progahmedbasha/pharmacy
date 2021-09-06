<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;
use DB;

class Product extends Model
{

	protected $appends =['total_quantity' , 'total_cost' , 'avg_cost'];

	public function getReactMaterialAttribute($value) {
        return $this->{'react_material_' . App::getLocale()};
    }

	public function productsDates()
	{
   		return $this->hasOne('App\Models\ProductDate', 'product_id');
	}

	public function dates()
	{
   		return $this->hasMany('App\Models\ProductDate', 'product_id')->with('store')->with('purchase_bill_product');
	}

	public function store()
	{
   		return $this->belongsTo('App\Models\Store', 'default_store_id');
	}

	public function type()
	{
   		return $this->belongsTo('App\Models\ProductType', 'product_type_id');
	}

	public function item()
	{
   		return $this->belongsTo('App\Models\Item', 'item_id');
	}

	public function getTotalQuantityAttribute($value) {
		return $this->dates()->sum('quantity');
    }

	public function getTotalCostAttribute($value) {
		return $this->dates()->sum(DB::raw('cost * quantity'));
    }

	public function getAvgCostAttribute($value) {
		if($this->total_quantity == 0)
			return 0;
		else
			return $this->total_cost/$this->total_quantity;
    }

}
