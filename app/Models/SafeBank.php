<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class SafeBank extends Model
{

	protected $guarded =[];

	public function getNameAttribute($value) {
        return $this->{'name_' . App::getLocale()};
    }

    public function tree(){
    	return $this->morphOne(TreeAccount::class,'tree_accountable');
    }
    public function scopeWhenSearch($query,$search){
        return $query->when($search,function($q)use($search){
            return $q->where('type',$search)
                ->orWhere('name_en','like',"%$search%")
                ->orWhere('name_ar','like',"%$search%")
                ->orWhere('description','like',"%$search%");
                
        });
      }


}
