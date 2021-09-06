<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnSaleProduct extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table='return_sale_products';
    public $timestamps=true;

    public function return_bill()
    {
        return $this->belongsTo('App\Models\ReturnSaleBill','return_id');
    }

    public function bill_products()
    {
        return $this->belongsTo('App\Models\SaleBillItem','bill_product_id')->with('product_date');
    }
}
