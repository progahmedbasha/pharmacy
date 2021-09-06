<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class InsuranceCompany extends Model
{

	public function getCompanyNameAttribute($value) {
        return $this->{'company_name_' . App::getLocale()};
    }

    public function getResponsibleNameAttribute($value) {
        return $this->{'responsible_name_' . App::getLocale()};
    }

	public function classes()
	{
		return $this->hasMany('App\Models\InsuranceCompanyClass', 'company_id');
	}

	public function tree()
	{
   		return $this->morphOne(TreeAccount::class,'tree_accountable');
	}
	public function scopeWhenSearch($query,$search){
        return $query->when($search,function($q)use($search){
            return $q->where('store_code',$search)
                ->orWhere('company_name_en','like',"%$search%")
                ->orWhere('company_name_ar','like',"%$search%");
              
        });
      }
}
