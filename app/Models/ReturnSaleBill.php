<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App;
use DB;
class ReturnSaleBill extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table='return_sale_bills';
    public $timestamps=true;

    public function bill()
    {
        return $this->belongsTo('App\Models\SaleBill', 'bill_id')->with('customer');
    }

    public function return_products()
    {
        return $this->hasMany('App\Models\ReturnSaleProduct','return_id')->with('bill_products');
    }

    public function return_payments()
    {
        return $this->hasMany('App\Models\ReturnSaleBillPayment','return_id')->with('user');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id')->with('tree');
    }

    public function scopeWhenSearch($query,$search){
        return $query->when($search,function($q)use($search){
            return $q->where('return_number',$search)
                ->orWhere('return_date','like',"%$search%")
                ->orWhere('total_amount','like',"%$search%");
        });
      }
}
