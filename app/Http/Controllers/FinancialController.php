<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

use App\Models\TreeAccount;
use App\Models\FinalAccount;
use App\Models\AccountingEntry;
use App\Models\EntryAction;
use App\Models\SafeBank;
use App\Http\Requests\AccountsRequest;

class FinancialController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function display_account_tree(){
        $allaccountslist = TreeAccount::where('account_type', 0)->get();

        $allaccounts = TreeAccount::whereNull('parent_id')->with('children')->get();

		$data['data'] =  $allaccounts;
//return $data;
		$core =  json_encode(array('core'=>$data));
        $final_accounts = FinalAccount::all();
        //return $core;->with('account_tree')

		//$core = json_encode($core2);
		//return $core;

        return view('admin.financial.accountstree2',compact('allaccounts', 'allaccountslist', 'core','final_accounts'));
    }

    public function add_new_accounttree(Request $request){
        $acc = TreeAccount::where('id',$request->acc_parent)->with('account')->first();
        if($request->acc_type == 0)
            $code = ($acc->id_code.count($acc->account)) + 1;
        else
            $code = ($acc->id_code.'0000')+ count($acc->account) + 1;
        //return $code;

        $account = new TreeAccount;
        $account->id_code = $code;
        $account->name_ar = $request->name_ar;
        $account->name_en = $request->name_en;
        $account->account_type = $request->acc_type;
        $account->parent_id = $request->acc_parent;
        $account->balance_type = $request->credit_debit;
        $account->user_id = auth()->user()->id;
        $account->final_account_id = $request->final_acc;
        $account->save();

        return redirect()->back();
    }


    ////////////////////////// Entries ///////////////////////////////////

    public function show_all_entries($paginationVal,Request $request){

        if(isset($request)){
            if(isset($request->search_val)){
              $entries =  AccountingEntry::with('actions')->
               where('id', $request->search_val)->paginate(100);
            }else if(isset($request->date_from) && isset($request->date_to)){
              $entries =  AccountingEntry::with('actions')->
             whereBetween('date', [$request->date_from,$request->date_to])->paginate(100);
            }else{
                $entries = AccountingEntry::with('actions')->paginate($paginationVal);
              }
        }else{
            $entries = AccountingEntry::with('actions')->paginate($paginationVal);
        }

        //$entries = AccountingEntry::with('actions')->paginate($paginationVal);
        return view('admin.financial.dailyentrylist',compact('entries', 'paginationVal'));
    }

    public function add_entry_page(){
        $tree_accounts = TreeAccount::where('account_type',1)->get();
        return view('admin.financial.dailyentry',compact('tree_accounts'));
    }

    public function add_new_entry(Request $request){
        //return $request;
        $entry = new AccountingEntry();
        $entry->type = 0;
        $entry->title_en = "Manual";
        $entry->title_ar = "يدوي";
        $entry->date = $request->ent_date;
        $entry->description = $request->ent_description;
        $entry->user_id = auth()->user()->id;
        $entry->save();
        foreach ($request->accounts as $key => $acc) {
            $account = TreeAccount::find($acc);
            if($account->balance_type == 0){
                $account->balance = $account->balance + ($request->credit)[$key];
                $account->balance = $account->balance - ($request->debit)[$key];
            }
            else{
                $account->balance = $account->balance - ($request->credit)[$key];
                $account->balance = $account->balance + ($request->debit)[$key];
            }
            $account->save();

            $action = new EntryAction();
            $action->entry_id = $entry->id;
            $action->tree_id = $acc;
            $action->credit = ($request->credit)[$key];
            $action->debit = ($request->debit)[$key];
            $action->balance = $account->balance;
            $action->description = ($request->description)[$key];
            $action->save();
        }

        Session::flash('success', 'تمت العملية بنجاح!');
        return redirect()->route('dailyentrylist',['paginationVal'=>10]);
    }

    public function entry_detail($id){
        $entry = AccountingEntry::with('actions')->find($id);
        return view('admin.financial.dailyentrydetail',compact('entry'));
    }

    public function print_daily_entry($id){
        $entry = AccountingEntry::with('actions')->find($id);
        return view('admin.financial.printdailyentry',compact('entry'));
    }

    ///////////////////// Safe & Bank //////////////////////////////

    private $safe_tree_id = 64;
    private $bank_tree_id = 65;

    public function show_all_safes_banks($paginationVal,Request $request){
        $safe_banks = SafeBank::whenSearch($request->search)->with('tree')->paginate($paginationVal);
        return view('admin.financial.treasurybanklist',compact('safe_banks','paginationVal'));
    }

    public function add_safe_bank_page(){
        return view('admin.financial.addtreasurybank');
    }

    public function add_new_safe_bank(Request $request){
        if($request->treasury_type == 0)
            $acc = TreeAccount::where('id',$this->safe_tree_id)->with('account')->first();
        else
            $acc = TreeAccount::where('id',$this->bank_tree_id)->with('account')->first();
        $code = ($acc->id_code.'0000')+count($acc->account)+1;

        $safe_bank = new SafeBank();
        $safe_bank->name_en = $request->treasury_name_en;
        $safe_bank->name_ar = $request->treasury_name_ar;
        $safe_bank->type = $request->treasury_type;
        $safe_bank->description = $request->treasury_description;
        $safe_bank->save();


        $account = new TreeAccount;
        $account->name_ar = $request->treasury_name_ar;
        $account->name_en = $request->treasury_name_en;
        $account->account_type = 1;
        if($request->treasury_type == 0)
            $account->parent_id = $this->safe_tree_id;
        else
            $account->parent_id = $this->bank_tree_id;
        $account->balance_type = 1;
        $account->user_id = auth()->user()->id;
        $account->final_account_id = 1;
        $account->id_code = $code;
        $safe_bank->tree()->save($account);


        Session::flash('success', 'تمت العملية بنجاح!');
        return redirect()->route('treasurybanklist');
    }

    public function edit_account($account_code)
    {
        $final_accounts = FinalAccount::all();
        $account = TreeAccount::where('id_code', $account_code)->first();
        return view('admin.financial.edit_account', compact('account', 'final_accounts'));
    }

    public function update_account(AccountsRequest $request)
    {
        $account = TreeAccount::findOrFail($request->account_id);
        $name_ar = $request->name_ar;
        $account->update([
            'name_ar'          => $request->name_ar,
            'name_en'          => $request->name_en,
            'balance_type'     => $request->credit_debit,
            'final_account_id' => $request->final_acc
        ]);

        toastr()->success("تم تعديل $name_ar  بنجاح");
        return redirect()->route('accountstree');

    }


}
