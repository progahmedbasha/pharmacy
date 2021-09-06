<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Department extends Model
{

	protected $fillable = [
        'status'
    ];

	public function getDepartmentAttribute($value) {
        return $this->{'department_' . App::getLocale()};
    }

    public function jobs()
	{
   		return $this->hasMany('App\Models\Job', 'department_id')->with('levels')->whereNull('parent_id');
	}
}
