<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class AccountingEntry extends Model
{
    //public $fillable = ['type', 'title_en', 'title_ar', 'date', 'description', 'source', 'user_id'];
    protected $guarded = [];

	public function getTitleAttribute($value) {
        return $this->{'title_' . App::getLocale()};
    }

	public function actions()
	{
   		return $this->hasMany('App\Models\EntryAction', 'entry_id');
	}
}
