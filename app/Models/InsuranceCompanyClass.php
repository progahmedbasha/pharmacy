<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsuranceCompanyClass extends Model
{
	public function company()
	{
   		return $this->belongsTo('App\Models\InsuranceCompany', 'company_id');
	}
}
