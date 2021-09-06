<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class SupplierCompanyInfo extends Model
{
	public function supplier()
	{
   		return $this->belongsTo('App\Models\Supplier', 'customer_id');
	}

	public function getCompanyNameAttribute($value) {
        return $this->{'company_name_' . App::getLocale()};
    }
}
