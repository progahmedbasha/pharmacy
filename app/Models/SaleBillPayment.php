<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleBillPayment extends Model
{
	public function bill()
	{
   		return $this->belongsTO('App\Models\SaleBill','bill_id');;
	}

	public function user()
	{
   		return $this->belongsTo('App\Models\User', 'user_id');
	}

}
