<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class EmployeeActivation extends Model
{
	public function getActivationAttribute($value) {
        return $this->{'activation_' . App::getLocale()};
    }
}
