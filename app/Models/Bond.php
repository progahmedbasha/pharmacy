<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bond extends Model
{
    protected $guarded = [];

    public function debit_rl(){

        return $this->hasOne(Account::class,'id','debit_id');

    }//end fun

    public function creditor_rl(){

        return $this->hasOne(Account::class,'id','creditor_id');

    }//end fun


}//end clASS
