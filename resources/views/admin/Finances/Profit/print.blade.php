
<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        th,td{
            font-size:11px;
            text-align:center;
        }

        .detail td{
            border:1px solid gray;
        }
        body {
            margin: 0;
            padding: 0;
        }

        @page {
            size: A4;
            margin: 0;
        }

        @media print {
            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
        }

    </style>
</head>

<body onload="window.print()">
<div class="page" style="width: 100%!important;">
    <center>
        <div id="elem" style="text-align:center;width:250px;height:auto;font-size:12px;">
            <img class="main-logo" src="{{url('img/Logo.png')}}" alt="" width="200px"><br>
            <span style="font-size:12px;"></span>
            <br>
            <hr>
            <table>
                <tbody>
                <tr>
                    <td>إجمالى المبيعات فى هذه الفترة</td>
                    <td>{{round($sale,3)}}</td>
                    <td>إجمالى المصروفات فى هذه الفترة</td>
                    <td>{{round($expenses,3)}}</td>
                </tr>
                <tr>
                    <td>إجمالى مرتجعات البيع فى هذه الفترة</td>
                    <td>{{round($saleBack,3)}}</td>
                    <td>إجمالى خصومات المبيعات فى هذه الفترة</td>
                    <td>{{round($discount,3)}}</td>
                </tr>
                <tr>

                    <td style="color: blue">إجمالى الأرباح فى هذه الفترة</td>
                    <td>{{round($total,3)}}</td>
                </tr>

                </tbody>
                <tfoot>

                </tfoot>
            </table>

            <br>
            <hr>
            <span>رقم الضريبي: 300668772300003</span>
            <br>
            <span>  رقم التواصل: 0172228534</span>
            <br>
            <span>  حي الضيافة -   مركز الدكتور عبدالكريم شكري</span>
            <br>
            <hr>

            <img src="data:image/png;base64,{{DNS1D::getBarcodePNG(1, 'C39','2','30')}}" alt="barcode" />
        </div>
    </center>
</div>
</body>





