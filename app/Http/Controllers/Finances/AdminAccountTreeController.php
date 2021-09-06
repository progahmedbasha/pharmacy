<?php

namespace App\Http\Controllers\Admin\Finances;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Account;

class AdminAccountTreeController extends Controller
{
    use LogActivityTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $accounts = Account::orderBy('parent_id','asc')
            ->orderBy('code','asc')
            ->get();


        // Get all parent top level category
        $accounts = Account::where('parent_id', NULL)->get();
        //return $accounts;
        // Get nestable data
        $accounts_tree = Account::nestable($accounts);



        $output = [
            'accounts'      => $accounts,
            'accounts_tree' => $accounts_tree,
        ];


        return view('admin.Finances.StatmentTree.index', $output);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        //make validation
        $validator = Validator::make($request->all(), [
            'account_type'   => 'required',
            'parent_account' => 'required',
            'code'           => 'required',
            'level'          => 'required',
            'name'           => 'required'
        ]);


        if ($validator->fails())
        {
            // validation fails
            //$validator->errors()
            return response(['status' => 'error', 'message' => 'من فضلك أدخل كل الحقول المطلوبة'], 200);
        }
        else
        {
            //validation success

            $account_type   = $request->account_type;
            $code           = $request->code;
            $level          = $request->level;
            $name           = $request->name;
            $parent_id      = $request->parent_account;

            //insert account data
            $account_data = [
                                'type'          => 'normal',
                                'account_type'  => $account_type,
                                'is_basic'      => 'no',
                                'code'          => $code,
                                'level'         => $level,
                                'name'          => $name,
                                'parent_id'     => $parent_id,
                            ];
            $new_account = Account::create($account_data);


            if($parent_id == 4 || $parent_id == 10)
            {
                $customer_type       = $parent_id== 4  ? 'client':'supplier';
                $client_account_id   = $parent_id== 4  ? $new_account->id:NULL;
                $supplier_account_id = $parent_id== 10 ? $new_account->id:NULL;

                //insert customer data
                $customer_data = [
                                    'type'                => $customer_type,
                                    'customer_status'     => 'single',
                                    'client_account_id'   => $client_account_id,
                                    'supplier_account_id' => $supplier_account_id,
                                    'name'                => $name,
                                    'code'                => $code
                                 ];

                $new_customer = Customer::create($customer_data);
            }

            return response(['status'=>'success', 'message'=>'تم الإضافة بنجاح'], 200);

        }
    }

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
        $decoded_request = json_decode($request->getContent(), true);
        foreach($decoded_request as $row)
        {
            $request_data[$row['name']] = $row['value'];
        }
        //
        //return $request_data;
        $account_data = Account::find($id);
        if(isset($account_data) )
        {
            //account exist


            //make validation
            $validator = Validator::make($request_data, [
            'name'   => 'required'
            ]);

            if ($validator->fails())
            {
                // validation fails
                return response(['status' => 'error', 'message' => 'من فضلك أدخل كل الحقول المطلوبة'], 200);
            }
            else
            {
                $account_data->update(['name'=>$request_data['name']]);
                return response(['status'=>'success', 'message'=>'تم التحديث بنجاح'], 200);
            }

        }
        else
        {
            //account not exist
            return response(['status' => 'error', 'message' => 'الحساب غير موجود'], 200);
        }
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
        $account_data = Account::findOrFail($id);

        $account_data->delete();
        return redirect()->back()->with(['success'=>'تم الحذف بنجاح']);
    }
}
