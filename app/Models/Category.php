<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Category extends Model
{
	public function getCategoryAttribute($value) {
        return $this->{'category_' . App::getLocale()};
    }

	public function main()
	{
   		return $this->belongsTo('App\Models\Category', 'parent_id');
	}

	public function sup_category()
	{
   		return $this->hasMany('App\Models\Category', 'parent_id');
	}
}
