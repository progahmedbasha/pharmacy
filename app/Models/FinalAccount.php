<?php

namespace App\Models;
use App;
use Illuminate\Database\Eloquent\Model;

class FinalAccount extends Model
{
	public function getFinalAccountAttribute($value) {
		return $this->{'final_account_' . App::getLocale()};
    }
}
