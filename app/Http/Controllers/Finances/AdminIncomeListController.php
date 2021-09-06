<?php

namespace App\Http\Controllers\Admin\Finances;

use App\Http\Controllers\Controller;
use App\Models\ReceiptVoucher;
use App\Models\ShippingAndClearance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminIncomeListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('admin.Finances.IncomeList.index');
    }//end fun

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
        if ($request->ajax()){

            $validator = Validator::make($request->all(), [
                'FromDate' => 'required',
                'ToDate' => 'required',
            ]);

            $output  = '';
            $message = '';
            $status  = 'yes';

            if ($validator->fails())
            {
                $status  = 'no';
                $message = 'من فضلك أدخل قيم الفلاتر';

                return response()->json(['status'=>$status, 'data'=>$output, 'message' => $message ]);
            }


            $fromDate = $request->FromDate;

            $toDate = $request->ToDate;




            $BillsOfLadingAndClearance = ShippingAndClearance::whereDate('created_at', '>=', $fromDate)
                ->whereDate('created_at', '<=', $toDate)->sum('total_amount');



            $DomesticFreightBills = ReceiptVoucher::whereDate('created_at', '>=', $fromDate)
                ->whereDate('created_at', '<=', $toDate)->sum('total_amount');

            $NetFreightBills = $DomesticFreightBills + $BillsOfLadingAndClearance;

            $output = '
            <tr><td colspan="3">'.trans('Finances.incoming').'</td></tr>
            <tr><td>'.trans('Finances.BillsOfLadingAndClearance').'</td> <td>'.$BillsOfLadingAndClearance.'</td><td> ر.س </td></tr>
            <tr><td>'.trans('Finances.DomesticFreightBills').'</td> <td>'.$DomesticFreightBills.'</td><td> ر.س </td></tr>
            <tr><td>'.trans('Finances.DiscountPermitted').'</td> <td>0</td><td> ر.س </td></tr>
            <tr><td><h6 style="font-weight: bolder">'.trans('Finances.NetFreightBills').'</h6></td> <td>'.$NetFreightBills.'</td><td> ر.س </td></tr>
            <tr><td colspan="3"><h6>'.trans('Finances.Costs').'</h6></td></tr>
            <tr><td>'.trans('Finances.Salaries').'</td> <td>0</td><td> ر.س </td></tr>
            <tr><td>'.trans('Finances.DiscountsAndPenalties').'</td> <td>0</td><td> ر.س </td></tr>
            <tr><td>'.trans('Finances.Equivalents').'</td> <td>0</td><td> ر.س </td></tr>
            <tr><td>'.trans('Finances.Advance').'</td> <td>0</td><td> ر.س </td></tr>
            <tr><td><h6 style="font-weight: bolder">'.trans('Finances.TotalCosts').'</h6></td> <td>0</td><td> ر.س </td></tr>
            ';

            return response()->json(['status'=>$status, 'data'=>$output, 'message' => $message ]);


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



        $fromDate = $request->FromDate;

        $toDate = $request->ToDate;




        $BillsOfLadingAndClearance = ShippingAndClearance::whereDate('created_at', '>=', $fromDate)
            ->whereDate('created_at', '<=', $toDate)->sum('total_amount');



        $DomesticFreightBills = ReceiptVoucher::whereDate('created_at', '>=', $fromDate)
            ->whereDate('created_at', '<=', $toDate)->sum('total_amount');

        $NetFreightBills = $DomesticFreightBills + $BillsOfLadingAndClearance;

        $output = '
            <tr><td colspan="3">'.trans('Finances.incoming').'</td></tr>
            <tr><td>'.trans('Finances.BillsOfLadingAndClearance').'</td> <td>'.$BillsOfLadingAndClearance.'</td><td> ر.س </td></tr>
            <tr><td>'.trans('Finances.DomesticFreightBills').'</td> <td>'.$DomesticFreightBills.'</td><td> ر.س </td></tr>
            <tr><td>'.trans('Finances.DiscountPermitted').'</td> <td>0</td><td> ر.س </td></tr>
            <tr><td><h6 style="font-weight: bolder">'.trans('Finances.NetFreightBills').'</h6></td> <td>'.$NetFreightBills.'</td><td> ر.س </td></tr>
            <tr><td colspan="3"><h6>'.trans('Finances.Costs').'</h6></td></tr>
            <tr><td>'.trans('Finances.Salaries').'</td> <td>0</td><td> ر.س </td></tr>
            <tr><td>'.trans('Finances.DiscountsAndPenalties').'</td> <td>0</td><td> ر.س </td></tr>
            <tr><td>'.trans('Finances.Equivalents').'</td> <td>0</td><td> ر.س </td></tr>
            <tr><td>'.trans('Finances.Advance').'</td> <td>0</td><td> ر.س </td></tr>
            <tr><td><h6 style="font-weight: bolder">'.trans('Finances.TotalCosts').'</h6></td> <td>0</td><td> ر.س </td></tr>
            ';

        return view('admin.Finances.IncomeList.print',compact('output','request'));

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
