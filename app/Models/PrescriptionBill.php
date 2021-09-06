<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class PrescriptionBill extends Model
{
	public function prescription()
	{
   		return $this->belongsTo('App\Models\Prescription', 'prescription_id')->with('patient')->with('doctor');
	}
}