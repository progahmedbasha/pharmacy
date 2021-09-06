<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Prescription extends Model{

	protected $fillable = [
        'is_bill',
        'bill_id',
    ];

	public function items()
	{
   		return $this->hasMany('App\Models\PrescriptionItem', 'prescription_id')->with('item');
	}

	public function patient()
	{
   		return $this->belongsTo('App\Models\Patient', 'patient_id');
	}

	public function doctor()
	{
   		return $this->belongsTo('App\Models\Doctor', 'doctor_id');
	}
}