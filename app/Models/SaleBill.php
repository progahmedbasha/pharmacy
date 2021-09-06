<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class SaleBill extends Model
{
	protected $appends = ['paid_amount'];
	protected $fillable = [
        'is_paid',
        'remaining_amount',
    ];

	public function entry()
	{
   		return $this->belongsTo('App\Models\AccountingEntry', 'entry_id');
	}

	public function user()
	{
   		return $this->belongsTo('App\Models\User', 'user_id');
	}

	public function customer()
	{
   		return $this->belongsTo('App\Models\Customer', 'customer_id')->with('tree');
	}

	public function employee()
	{
   		return $this->belongsTo('App\Models\Employee', 'employee_id')->with('tree');
	}

	public function bill_items()
	{
   		return $this->hasMany('App\Models\SaleBillItem','bill_id')->with('item');
	}

	public function bill_payments()
	{
   		return $this->hasMany('App\Models\SaleBillPayment','bill_id')->with('user');
	}

	public function prescription_bills()
	{
		return $this->hasOne('App\Models\PrescriptionBill','bill_id')->with('prescription');	
	}

	/*public function prescription()
	{
   		return $this->prescription_bills()->prescription;
	}*/


	public function getPaidAmountAttribute($value) {
		return $this->bill_payments()->sum(DB::raw('cash + visa'));
		
    }

    public function getRemainingAmountAttribute($value) {
    	if($this->customer()->first()->type == 1){
    		return $value;
    	}
    	else
			return 0;
    }
    
    public function return_bills()
    {
        return $this->hasMany('App\Models\ReturnSaleBill', 'bill_id');
    }
}
