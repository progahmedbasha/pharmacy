<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;
use DB;

class Customer extends Model
{

	protected $guarded =[];

	protected $fillable = [
        'isActive'
    ];

    /*public function tree(){
   		return $this->belongsTo('App\Models\TreeAccount', 'tree_id');
	}*/

	public function company(){
		return $this->hasOne('App\Models\CustomerCompanyInfo', 'customer_id');
	}

	public function insurance_class(){
		return $this->hasOne('App\Models\InsuranceCustomer', 'customer_id')->with('class');
	}

	public function user(){
   		return $this->belongsTo('App\Models\User', 'user_id');
	}

	public function activation(){
   		return $this->belongsTo('App\Models\Activation', 'isActive');
	}

	public function getNameAttribute($value) {
        return $this->{'name_' . App::getLocale()};
    }

    public function tree(){
    	return $this->morphOne(TreeAccount::class,'tree_accountable')->with('entry_action');
    }

    public function saleBills()
    {
        return $this->hasMany(SaleBill::class, 'customer_id');
    }

    public function returnSaleBills()
    {
        return $this->hasMany(ReturnSaleBill::class, 'customer_id');
    }

    public function scopeWhenSearch($query,$search){
        return $query->when($search,function($q)use($search){
            return $q->where('phone',$search)
                ->orWhere('name_en','like',"%$search%")
                ->orWhere('name_ar','like',"%$search%")
                ->orWhere('email','like',"%$search%")
                ->orWhere('city','like',"%$search%");
        });
      }

}
