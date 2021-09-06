<?php

namespace App\Http\Controllers\Admin\Finances;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Models\Account;
use Illuminate\Http\Request;

class AdminAccountsController extends Controller
{
    use LogActivityTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['accounts'] = Account::orderBy('parent_id','asc')
            ->orderBy('code','asc')
            ->get();
        $data['branches'] = Branch::get();
        $data['types'] =[
            'basics'=>"أساسيات شجرة الحسابات",
            'purchases'=>'المشتريات',
            'sales'=>'المبيعات',
            'back_purchases'=>'مردودد المستريات',
            'back_sales'=>'مرتجع المبيعات',
            'banks'=>'بنوك',
            'drivers'=>'السائقين',
            'clients'=>"العملاء",
            'suppliers'=>"الموردين",
            'box'=>"الخزنات",
            'storage'=>"المخزون",
            'catch_papers'=>"أوراق القبض",
            'exchange_papers'=>"أوراق الصرف",
            'normal'=>"حساب عادى",

            'alsalaf'=>"السلف",
            'employees'=>"الموظفين",
            'rewards'=>"المكافئات",
            'Allowances'=>"البدلات",

        ];

        return  view('admin.modules.system-settings.accounts.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validation
        $request->validate([
            'is_parent'=>'required',
        ],[
            'is_parent.required'=>'اختر نوع الحساب'
        ]);
        $data = $request->validate([
            'name'=>'required',
            'code'=>'required',
            'level'=>'required',
            'type'=>'required',
            'parent_id'=>'nullable',
            'branch_id'=>'nullable',
        ]);

        if ($request->is_parent == 'parent') {
            $data['is_basic'] ="yes";
            $data['parent_id'] =null;
            $data['branch_id'] =null;
        }else{
            $data['is_basic'] ="no";
        }

        $account = Account::create($data);
        return  response()->json(1,200);
    }//end fun


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * Algorithm of account coding
     *
     */
    public function getAccountCode(Request $request)
    {
        $return_object = [
            'code'=>null,
            'level'=>'1',
        ];

        //when parent account is creating
        if ($request->is_parent == 'parent') {
            $account = Account::whereNull('parent_id')
                ->orderBy('code','desc')
                ->first();
            if ($account) {
                $str = rtrim($account->code, '0');
                $code = str_pad($str+1, 15, "0", STR_PAD_RIGHT);
                $return_object['code'] = $code;

                return response()->json($return_object,200);
            }else{
                $code = str_pad(1, 15, "0", STR_PAD_RIGHT);
                $return_object['code'] = $code;
                return response()->json($return_object,200);
            }
        }//end

        //when Child account is creating
        if ($request->is_parent == 'child') {
            $account = Account::where('parent_id',$request->parent_id)
                ->orderBy('code','desc')
                ->first();
            if ($account) {
                $str = (int)rtrim($account->code, '0');
                $code = str_pad($str +1, 15, "0", STR_PAD_RIGHT);
                $return_object['code'] = $code;
                $return_object['level'] = $account->level;
                return response()->json($return_object,200);
            }else{
                $account = Account::where('id',$request->parent_id)
                    ->orderBy('code','desc')
                    ->firstOrFail();
                $str = (int)rtrim($account->code, '0');
                $num_length_of_parent = strlen((string)$str);
               // $parent_code_without_zeros = (int)substr($account->code, $num_length_of_parent);
                $level_of_parent = $account->level ;
                $level_of_child = $level_of_parent+1 ;

                $i = 0;
                $sum = 0;
                for ($i = 0; $i <= $level_of_child; $i++) {
                    $sum += $i;
                }
                $code = str_pad($str, $sum, "0", STR_PAD_RIGHT);
                $code = str_pad($code+1 , 15, "0", STR_PAD_RIGHT);
                $return_object['code'] = $code;
                $return_object['level'] = $level_of_child;
                return response()->json($return_object,200);
            }
        }//end

    }//END


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
