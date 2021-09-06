<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class ContractType extends Model
{
	public function getContractTypeAttribute($value) {
        return $this->{'contract_type_' . App::getLocale()};
    }
}
