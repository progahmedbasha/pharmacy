<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;





use App\Models\SaleBill;

use PDF;

class SalesReport extends Controller
{
    //


    public function list_all_bills($paginationVal,Request $request){
        // $paginationVal = 50;

        $total_final      = SaleBill::doesnthave('prescription_bills')->sum('total_final');
        $remaining_amount = SaleBill::doesnthave('prescription_bills')->sum('remaining_amount');
        $paid_amount      = round($total_final- $remaining_amount, 2);

        if(isset($request)){
            if(isset($request->search_val)){
              $bills = SaleBill::doesnthave('prescription_bills')->with('user')->with('customer')->
               where('bill_number', $request->search_val)->paginate(100);
            }else if(isset($request->date_from) && isset($request->date_to)){
                $bills = SaleBill::doesnthave('prescription_bills')->with('user')->with('customer')->
                whereBetween(DB::raw('DATE(created_at)'), [$request->date_from,$request->date_to])->paginate(100);
            }else{
                $bills = SaleBill::doesnthave('prescription_bills')->with('user')->with('customer')->paginate($paginationVal);
            }
        }else{
            $bills = SaleBill::doesnthave('prescription_bills')->with('user')->with('customer')->paginate($paginationVal);
        }

        //return $bills;
        $report_page = true;

        return view('admin.reports.managebill',compact('bills' , 'paginationVal' ,'total_final','paid_amount', 'remaining_amount', 'report_page'));
    }

    public function short_bills_report(Request $request)
    {
        $rows = '<tr><td class="text-center" colspan="2">أختر التاريخ لعرض البيانات</td></tr>';
        $date_from = $request->date_from;
        $date_to   = $request->date_to;

        if($date_from && $date_to)
        {
            //total sales
            $total_sales = SaleBill::whereBetween('bill_date', [$date_from, $date_to])
                ->sum('total_final');
            $total_sales = round($total_sales, 2);

            $rows = '<tr><td>إجمالى المبيعات  </td><td>'.$total_sales.'</td></tr>';

            //total sales with no tax
            $total_sales_with_no_tax = SaleBill::whereBetween('bill_date', [$date_from, $date_to])
                ->where('total_tax', 0)
                ->sum('total_final');
            $total_sales_with_no_tax = round($total_sales_with_no_tax, 2);

            $rows .= '<tr><td>إجمالى المبيعات الغير خاضعة للضرائب</td><td>'.$total_sales_with_no_tax.'</td></tr>';


            //total sales with tax
            $total_sales_with_tax = SaleBill::whereBetween('bill_date', [$date_from, $date_to])
                ->where('total_tax', '!=', 0)
                ->sum('total_final');
            $total_sales_with_tax = round($total_sales_with_tax, 2);

            $rows .= '<tr><td>إجمالى المبيعات الخاضعة للضرائب</td><td>'.$total_sales_with_tax.'</td></tr>';

            // tax
            $total_tax = SaleBill::whereBetween('bill_date', [$date_from, $date_to])
                ->sum('total_tax');
            $total_tax = round($total_tax, 2);

            $rows .= '<tr><td>إجمالى  الضرائب</td><td>'.$total_tax.'</td></tr>';

            // tax
            $count = SaleBill::whereBetween('bill_date', [$date_from, $date_to])
                ->count();

            $rows .= '<tr><td>عدد الفواتير</td><td>'.$count.'</td></tr>';

        }
        return view('admin.reports.short_sales_report', compact('rows'));
    }
}
