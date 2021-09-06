<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class CustomerCompanyInfo extends Model
{
	public function customer()
	{
   		return $this->belongsTo('App\Models\Customer', 'customer_id');
	}

	public function getCompanyNameAttribute($value) {
        return $this->{'company_name_' . App::getLocale()};
    }
}
