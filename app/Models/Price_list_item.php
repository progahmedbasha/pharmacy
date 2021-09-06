<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price_list_item extends Model
{
    use HasFactory;
    protected $fillable = ['price_list_id', 'item_id', 'qty', 'price'];

    public function item_details()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
