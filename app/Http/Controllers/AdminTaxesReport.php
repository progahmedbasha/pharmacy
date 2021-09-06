<?php

namespace App\Http\Controllers;

use App\Models\PurchaseBill;
use App\Models\ReturnPurchaseBill;
use App\Models\ReturnSaleBill;
use App\Models\SaleBill;
use Illuminate\Http\Request;

class AdminTaxesReport extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $rows = '<tr><td class="text-center" colspan="2">من فضلك أدخل قيم الفلاتر</td></tr>';
        $date_from = $request->date_from;
        $date_to   = $request->date_to;
        $tax_type  = $request->tax_type;  //0=>short tax report, 1=>detailed tax report



        if(isset($request->date_from) && isset($request->date_to) && isset($request->tax_type) )
        {

            if($tax_type == 0)
            {
                //short tax report

                //sales total before tax
                $total_sales_before_tax = SaleBill::whereBetween('bill_date', [$date_from, $date_to])
                    ->sum('total_before_tax');
                $total_sales_before_tax = round($total_sales_before_tax, 2);

                $rows = '<tr><td>إجمالى المبيعات قبل الضرائب</td><td>'.$total_sales_before_tax.'</td></tr>';

                //total sales with no tax
                $total_sales_with_no_tax = SaleBill::whereBetween('bill_date', [$date_from, $date_to])
                    ->where('total_tax', 0)
                    ->sum('total_before_tax');
                $total_sales_with_no_tax = round($total_sales_with_no_tax, 2);

                $rows .= '<tr><td>إجمالى المبيعات الغير خاضعة للضرائب</td><td>'.$total_sales_with_no_tax.'</td></tr>';

                //total sales with  tax
                $total_sales_with_tax = SaleBill::whereBetween('bill_date', [$date_from, $date_to])
                    ->where('total_tax', 0, '!=')
                    ->sum('total_before_tax');
                $total_sales_with_tax = round($total_sales_with_tax, 2);

                $rows .= '<tr><td>إجمالى المبيعات الخاضعة للضرائب</td><td>'.$total_sales_with_tax.'</td></tr>';

                //total tax on sales
                $total_sales_with_tax = SaleBill::whereBetween('bill_date', [$date_from, $date_to])
                    ->sum('total_tax');
                $total_sales_with_tax = round($total_sales_with_tax, 2);

                $rows .= '<tr><td>إجمالى الضريبة على المبيعات</td><td>'.$total_sales_with_tax.'</td></tr>';

                //total sales
                $total_sales = SaleBill::whereBetween('bill_date', [$date_from, $date_to])
                    ->sum('total_final');
                $total_sales = round($total_sales, 2);

                $rows .= '<tr style="background-color: rgb(139, 194, 76);"><td>إجمالى المبيعات بعد الضرائب</td><td>'.$total_sales.'</td></tr>';

                //purchases before tax
                $purchases_before_tax = PurchaseBill::whereBetween('bill_date', [$date_from, $date_to])
                    ->sum('total_before_tax');
                $purchases_before_tax = round($purchases_before_tax, 2);

                $rows .= '<tr><td>إجمالى المشتريات قبل الضرائب </td><td>'.$purchases_before_tax.'</td></tr>';

                //purchases with no tax
                $purchases_with_no_tax = PurchaseBill::whereBetween('bill_date', [$date_from, $date_to])
                    ->where('total_tax', 0)
                    ->sum('total_before_tax');
                $purchases_with_no_tax = round($purchases_with_no_tax, 2);

                $rows .= '<tr><td>إجمالى المشتريات الغير خاضعة للضرائب </td><td>'.$purchases_with_no_tax.'</td></tr>';

                //purchases with tax
                $purchases_with_tax = PurchaseBill::whereBetween('bill_date', [$date_from, $date_to])
                    ->where('total_tax', 0, '!=')
                    ->sum('total_before_tax');
                $purchases_with_tax = round($purchases_with_tax, 2);

                $rows .= '<tr><td>إجمالى المشتريات الغير خاضعة للضرائب </td><td>'.$purchases_with_tax.'</td></tr>';

                //purchases tax
                $purchases_tax = PurchaseBill::whereBetween('bill_date', [$date_from, $date_to])
                    ->sum('total_tax');
                $purchases_tax = round($purchases_tax, 2);

                $rows .= '<tr><td>إجمالى ضرائب المشتريات</td><td>'.$purchases_tax.'</td></tr>';

                //purchases
                $total_purchases = PurchaseBill::whereBetween('bill_date', [$date_from, $date_to])
                    ->sum('total_final');
                $total_purchases = round($total_purchases, 2);

                $rows .= '<tr style="background-color: rgb(120, 254, 224);"><td>إجمالى المشتريات بعد الضرائب</td><td>'.$total_purchases.'</td></tr>';

                //sales return before tax
                $total_sales_return = ReturnSaleBill::whereBetween('return_date', [$date_from, $date_to])
                    ->sum('total_before_tax');
                $total_sales_return = round($total_sales_return, 2);

                $rows .= '<tr><td> إجمالى فواتير مرتجعات المبيعات قبل الضرائب</td><td>'.$total_sales_return.'</td></tr>';

                //sales return tax
                $total_sales_return_tax = ReturnSaleBill::whereBetween('return_date', [$date_from, $date_to])
                    ->sum('total_tax');
                $total_sales_return_tax = round($total_sales_return_tax, 2);

                $rows .= '<tr><td> إجمالى ضرائب فواتير مرتجعات المبيعات</td><td>'.$total_sales_return_tax.'</td></tr>';

                //total sales return
                $total_sales_return = ReturnSaleBill::whereBetween('return_date', [$date_from, $date_to])
                    ->sum('total_amount');
                $total_sales_return = round($total_sales_return, 2);

                $rows .= '<tr style="background-color: rgb(185, 237, 248);"><td>إجمالى  فواتير مرتجعات المبيعات بعد الضرائب</td><td>'.$total_sales_return.'</td></tr>';

                //--------------------

                //purchase return before tax
                $total_purchase_return = ReturnPurchaseBill::whereBetween('return_date', [$date_from, $date_to])
                ->sum('total_before_tax');
                $total_purchase_return = round($total_purchase_return, 2);

                $rows .= '<tr><td> إجمالى فواتير مرتجعات المشتريات قبل الضرائب</td><td>'.$total_purchase_return.'</td></tr>';

                //purchase return tax
                $total_purchase_return_tax = ReturnPurchaseBill::whereBetween('return_date', [$date_from, $date_to])
                    ->sum('total_tax');
                $total_purchase_return_tax = round($total_purchase_return_tax, 2);

                $rows .= '<tr><td> إجمالى ضرائب فواتير مرتجعات المشتريات</td><td>'.$total_purchase_return_tax.'</td></tr>';

                //total purchase return
                $total_purchase_return = ReturnPurchaseBill::whereBetween('return_date', [$date_from, $date_to])
                    ->sum('total_amount');
                $total_purchase_return = round($total_purchase_return, 2);

                $rows .= '<tr style="background-color: rgb(185, 237, 248);"><td>إجمالى  فواتير مرتجعات المشتريات بعد الضرائب</td><td>'.$total_purchase_return.'</td></tr>';

            }
            else
            {
                //detailed tax report

                $rows = '';

                $sales            = SaleBill::with('customer')->get();
                $return_sale_bill = ReturnSaleBill::with('bill')->get();
                $purchase_bill    = PurchaseBill::with('supplier')->get();
                $purchases_return = ReturnPurchaseBill::with('bill')->get();

                foreach($sales as $sale)
                {
                    $rows .= '<tr>
                                <td>'.$sale->bill_number.'</td>
                                <td>مبيعات</td>
                                <td>'.$sale->bill_date.'</td>
                                <td>'.$sale->customer->name_ar.'</td>
                                <td>'.$sale->total_before_tax.'</td>
                                <td>'.$sale->total_tax.'</td>
                                <td>'.$sale->total_final.'</td>
                              </tr>';
                }

                foreach($return_sale_bill as $sale)
                {
                    $rows .= '<tr>
                                <td>'.$sale->return_number.'</td>
                                <td>مرتجع مبيعات</td>
                                <td>'.$sale->return_date.'</td>
                                <td>'.$sale->bill->customer->name_ar.'</td>
                                <td>'.$sale->total_before_tax.'</td>
                                <td>'.$sale->total_tax.'</td>
                                <td>'.$sale->total_final.'</td>
                              </tr>';
                }

                foreach($purchase_bill as $row)
                {
                    $rows .= '<tr>
                                <td>'.$row->bill_number.'</td>
                                <td>مشتريات</td>
                                <td>'.$row->bill_date.'</td>
                                <td>'.$row->supplier->name_ar.'</td>
                                <td>'.$row->total_before_tax.'</td>
                                <td>'.$row->total_tax.'</td>
                                <td>'.$row->total_final.'</td>
                              </tr>';
                }

//return $purchases_return;

                foreach($purchases_return as $row)
                {
                    $rows .= '<tr>
                                <td>'.$row->return_number.'</td>
                                <td>مرتجع مشتريات</td>
                                <td>'.$row->return_date.'</td>
                                <td>'.$row->bill->supplier->name_ar.'</td>
                                <td>'.$row->total_before_tax.'</td>
                                <td>'.$row->total_tax.'</td>
                                <td>'.$row->total_final.'</td>
                              </tr>';
                }

            }
        }
        return view('admin.reports.tax_report', compact('rows'));
    }
}
