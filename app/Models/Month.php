<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Month extends Model
{
	public function getMonthAttribute($value) {
        return $this->{'month_' . App::getLocale()};
    }

}
