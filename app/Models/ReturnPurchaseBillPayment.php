<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class ReturnPurchaseBillPayment extends Model
{
	public function user()
	{
   		return $this->belongsTo('App\Models\User', 'user_id');
	}
}
