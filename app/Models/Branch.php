<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Branch extends Model
{
	public function getNameAttribute($value) {
        return $this->{'name_' . App::getLocale()};
    }

    public function employee()
	{
   		return $this->belongsTo('App\Models\Employee', 'employee_id');
	}

	public function country()
	{
   		return $this->belongsTo('App\Models\Country', 'country_id');
	}
}
