<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price_list extends Model
{
    use HasFactory;
    protected $fillable=['date', 'expire_date', 'created_by', 'pricelist_number', 'total', 'employee_id', 'status'];

    public function creator()
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }



    public function employee()
    {
        return $this->belongsTo(Customer::class, 'employee_id');
    }

    public function items()
    {
        return $this->hasMany(Price_list_item::class, 'price_list_id');
    }
}
