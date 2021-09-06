<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class PurchaseBill extends Model
{
	protected $appends = ['paid_amount'];

	protected $fillable = [
        'is_paid',
        'remaining_amount',
    ];

	public function entry()
	{
   		return $this->belongsTo('App\Models\AccountingEntry', 'entry_id');
	}

	public function user()
	{
   		return $this->belongsTo('App\Models\User', 'user_id');
	}

	public function supplier()
	{
   		return $this->belongsTo('App\Models\Supplier', 'supplier_id');
	}

	public function store()
	{
   		return $this->belongsTo('App\Models\Store', 'store_id');
	}

	public function bill_products()
	{
   		return $this->hasMany('App\Models\PurchaseBillProduct','bill_id')->with('product_date');//->with('bill_item_product');
	}

	public function bill_payments()
	{
   		return $this->hasMany('App\Models\PurchaseBillPayment','bill_id')->with('user');
	}

	public function employee()
	{
   		return $this->belongsTo('App\Models\Employee', 'employee_id')->with('tree');
	}

	public function getPaidAmountAttribute($value) {
		return $this->bill_payments()->sum(DB::raw('cash + visa'));
		
    }

    public function getRemainingAmountAttribute($value) {
    	if($this->supplier()->first()->type == 1){
    		return $value;
    	}
    	else
			return 0;
    }

}
