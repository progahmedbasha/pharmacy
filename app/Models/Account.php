<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{

    protected $table='tree_accounts';


    protected $guarded = [];

    //---------------- scope ------------------

    public function scopeFilterForPurchases($query,$id,$arr=[])
    {

            $query->where("id",$id)
                ->orWhere("parent_id",$id);


    }//end scope

    public function children_accounts()
    {
        return $this->hasMany(Account::class,'parent_id');
    }

    public function grand_children_accounts()
    {
        return $this->children_accounts()->with('grand_children_accounts');
    }

    //  nestable child.
    public static function nestable($accounts) {
       foreach ($accounts as $account) {
           if (!$account->children_accounts->isEmpty()) {
               $account->children_accounts = self::nestable($account->children_accounts);
            }
        }

        return $accounts;
    }

    //observe this model being deleted and delete the child activities
    public static function boot ()
    {
        parent::boot();

        self::deleting(function (Account $account) {

            foreach ($account->grand_children_accounts as $sub)
            {
                $sub->delete();
            }
        });
    }



//    public function scopeFilterForUsers($query,$id,$arr=[])
//    {
//        $user_job = auth()->user()->user_job;
//
//        if (in_array($user_job->user_type,['super_admin','general_accountant','branch_accountant'])) {
//            $query->where("id",$id)
//                ->orWhere("parent_id",$id);
//        }else{
//            $query->where("id",$id)
//                ->orWhere(function ($q)use($id,$user_job){
//                    $q->where("parent_id",$id)
//                        ->where("branch_id",$user_job->branch_id);
//                });
//        }
//    }//end scope

}//end  class
