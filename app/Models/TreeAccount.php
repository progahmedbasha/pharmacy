<?php

namespace App\Models;
use App;
use Illuminate\Database\Eloquent\Model;

class TreeAccount extends Model
{
	//protected $hidden = ['id','id_code','name_ar','account_type','final_account_id','user_id', 'parent_id', 'status', 'created_at', 'updated_at'];
	protected $guarded =[];
    protected $appends =['text','a_attr'];

	public function getNameAttribute($value) {
        //return $this->{'name_ar'};
		 return $this->{'name_' . App::getLocale()};
    }

	public function account()
	{
   		return $this->hasMany('App\Models\TreeAccount', 'parent_id');
	}

// recursive, loads all descendants
	public function account_tree()
	{
	   return $this->account()->with('account_tree');
	   // which is equivalent to:
	   // return $this->hasMany('Survey', 'parent')->with('childrenRecursive);
	}

	public function children()
	{
	   return $this->account()->with('children');
	   // which is equivalent to:
	   // return $this->hasMany('Survey', 'parent')->with('childrenRecursive);
	}

	public function getTextAttribute($value) {
        //return $this->{'name_ar'};
        if($this->account_type == 1) {
            $type = 'داين';
        }
        else
        {
            $type = 'مدين';
        }
		 return $this->{'name_' . App::getLocale()}  .' - الرصيد : '.$this->balance . '('.$type.')'.'   #'.$this->id_code.' ';
    }

	public function getAAttrAttribute($value) {
		$respo['href'] = url('/customerlist');
		$x = $respo;
		//$x = {'href': url('/customerlist')};
		return $x;
    }

    public function tree_accountable(){
    	return $this->morphTo();
    }

    public function entry_action(){
    	return $this->hasMany('App\Models\EntryAction', 'tree_id')->with('entry');
    }
}
