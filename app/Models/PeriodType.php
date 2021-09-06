<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class PeriodType extends Model
{
	public function getPeriodTypeAttribute($value) {
        return $this->{'period_type_' . App::getLocale()};
    }
}
