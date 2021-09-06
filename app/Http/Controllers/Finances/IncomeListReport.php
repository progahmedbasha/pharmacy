<?php

namespace App\Http\Controllers\Finances;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ProductDate;
use App\Models\PurchaseBill;
use App\Models\SaleBill;
use Illuminate\Http\Request;

class IncomeListReport extends Controller
{
    //
    public function index(Request $request)
    {
        $rows = '<tr><td class="text-center" colspan="2">أختر التاريخ لعرض البيانات</td></tr>';
        $date_from = $request->date_from;
        $date_to   = $request->date_to;

        if($request->date_from && $request->date_to)
        {
            //purchases before tax
            $purchases_before_tax = PurchaseBill::whereBetween('bill_date', [$date_from, $date_to])
                ->sum('total_before_tax');
            $purchases_before_tax = round($purchases_before_tax, 2);

            $rows = '<tr><td>إجمالى المشتريات قبل الضرائب </td><td>'.$purchases_before_tax.'</td></tr>';


            //purchases tax
            $purchases_tax = PurchaseBill::whereBetween('bill_date', [$date_from, $date_to])
                ->sum('total_tax');
            $purchases_tax = round($purchases_tax, 2);

            $rows .= '<tr><td>إجمالى ضرائب المشتريات</td><td>'.$purchases_tax.'</td></tr>';

            //purchases
            $total_purchases = PurchaseBill::whereBetween('bill_date', [$date_from, $date_to])
                ->sum('total_final');
            $total_purchases = round($total_purchases, 2);

            $rows .= '<tr><td>إجمالى المشتريات</td><td>'.$total_purchases.'</td></tr>';

            //sales
            $total_sales_before_tax = SaleBill::whereBetween('bill_date', [$date_from, $date_to])
                                    ->sum('total_before_tax');
            $total_sales_before_tax = round($total_sales_before_tax, 2);

           $rows .= '<tr><td>إجمالى المبيعات من دون الضرائب</td><td>'.$total_sales_before_tax.'</td></tr>';

           //total tax
            $total_taxes = SaleBill::whereBetween('bill_date', [$date_from, $date_to])
                ->sum('total_tax');
            $total_taxes = round($total_taxes, 2);

            $rows .= '<tr><td>إجمالى الضرائب</td><td>'.$total_taxes.'</td></tr>';

            //total sales
            $total_sales = SaleBill::whereBetween('bill_date', [$date_from, $date_to])
                ->sum('total_final');
            $total_sales = round($total_sales, 2);

            $rows .= '<tr><td>إجمالى المبيعات بعد الضرائب</td><td>'.$total_sales.'</td></tr>';



            //totals
            $profit_before_tax = $total_sales  - $total_purchases;
            $rows .= '<tr><td>إجمالى الأرباح قبل الضرائب</td><td>'.$profit_before_tax.'</td></tr>';

            //totals
            $profit_after_tax = $total_sales_before_tax  - $total_purchases;
            $rows .= '<tr><td>إجمالى الأرباح بعد الضرائب</td><td>'.$profit_after_tax.'</td></tr>';
        }
        return view('admin.Finances.incomeList', compact('rows'));
    }


}
