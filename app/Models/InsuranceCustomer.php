<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class InsuranceCustomer extends Model
{
	public function customer()
	{
   		return $this->belongsTo('App\Models\Customer', 'customer_id');
	}

	public function class()
	{
		return $this->hasMany('App\Models\InsuranceCompanyClass', 'insurance_class_id')->with('company');
	}
}