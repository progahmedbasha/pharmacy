<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;
use DB;

class Supplier extends Model
{

	protected $fillable = [
        'isActive'
    ];
    
	public function company()
	{
   		return $this->hasOne('App\Models\SupplierCompanyInfo', 'supplier_id');
	}

	public function user()
	{
   		return $this->belongsTo('App\Models\User', 'user_id');
	}

	public function tree()
	{
   		return $this->morphOne(TreeAccount::class,'tree_accountable')->with('entry_action');
	}

	public function activation()
	{
   		return $this->belongsTo('App\Models\Activation', 'isActive');
	}

	public function getNameAttribute($value) {
        return $this->{'name_' . App::getLocale()};
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
