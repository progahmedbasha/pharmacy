<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class ReturnPurchaseBill extends Model
{
	protected $fillable = [
        'isClosed',
        'payment_status',
    ];

	public function bill()
	{
   		return $this->belongsTo('App\Models\PurchaseBill', 'bill_id')->with('supplier');
	}

	public function return_products()
	{
   		return $this->hasMany('App\Models\ReturnPurchaseProduct','return_id')->with('bill_products');
	}

	public function return_payments()
	{
   		return $this->hasMany('App\Models\ReturnPurchaseBillPayment','return_id')->with('user');
	}

	public function user()
	{
   		return $this->belongsTo('App\Models\User', 'user_id');
	}
	public function scopeWhenSearch($query,$search){
        return $query->when($search,function($q)use($search){
            return $q->where('return_number',$search)
                ->orWhere('return_date','like',"%$search%")
                ->orWhere('total_amount','like',"%$search%");
        });
      }
}