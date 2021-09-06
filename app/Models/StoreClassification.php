<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class StoreClassification extends Model
{
  public function getClassifyAttribute($value) {
        return $this->{'classify_' . App::getLocale()};
    }
}