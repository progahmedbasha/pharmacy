<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Doctor extends Model
{
	public function getNameAttribute($value) {
        return $this->{'name_' . App::getLocale()};
    }

    public function my_account(){
		return $this->hasOne('App\Models\User', 'user_doctor_id');
	}

	public function user(){
   		return $this->belongsTo('App\Models\User', 'user_id');
	}
	public function scopeWhenSearch($query,$search){
        return $query->when($search,function($q)use($search){
            return $q->where('doc_code',$search)
                ->orWhere('name_en','like',"%$search%")
                ->orWhere('name_ar','like',"%$search%")
                ->orWhere('email','like',"%$search%")
                ->orWhere('phone','like',"%$search%")
                ->orWhere('clinic_type','like',"%$search%");
        });
      }
}
