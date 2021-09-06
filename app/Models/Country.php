<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Country extends Model
{
	public function getCountryAttribute($value) {
        return $this->{'country_' . App::getLocale()};
    }
}