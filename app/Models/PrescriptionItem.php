<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class PrescriptionItem extends Model{

	public function item()
	{
   		return $this->belongsTo('App\Models\Item', 'item_id')->with('product');
	}
}