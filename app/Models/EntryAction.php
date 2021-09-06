<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntryAction extends Model
{
    protected $guarded = [];

	public function entry()
	{
   		return $this->belongsTo('App\Models\AccountingEntry', 'entry_id');
	}

	public function tree()
	{
   		return $this->belongsTo('App\Models\TreeAccount', 'tree_id');
	}
}
