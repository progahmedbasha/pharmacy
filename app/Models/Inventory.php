<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App;
class Inventory extends Model
{
   public function store()
	{
   		return $this->belongsTo('App\Models\Store');
	}

}
