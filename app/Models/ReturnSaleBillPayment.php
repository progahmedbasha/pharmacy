<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnSaleBillPayment extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table='return_sale_bill_payments';
    public $timestamps=true;
}
