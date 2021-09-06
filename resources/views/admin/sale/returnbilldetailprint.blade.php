
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
<div class="page">
    <center>
        <div id="elem" style="text-align:center;width:250px;height:auto;font-size:12px;">
            <img class="main-logo" src="{{url('img/Logo.png')}}" alt="" width="200px"><br>
            <span style="font-size:12px;"></span>
            <br>
            <table class="detail" width="100%">
                <tr>
                    <td colspan="4">فاتورة إرجاع المبيعات</td>
                </tr>
                <tr>
                    <td>رقم</td>
                    <td>{{$find->id}}</td>
                    <td>وقت</td>
                    <td>{{$find->created_at}}</td>
                </tr>
                <tr>
                    <td>عميل</td>
                    <td>{{$find->bill->customer->name}}</td>
                </tr>
            </table>
            <hr>
            <table>
                <tr>
                    <th style="width:200px;">الصنف</th>
                    <th>السعر</th>
                    <th>الكمية</th>
{{--                    <th>الخصم</th>--}}
                </tr>
                @foreach($find->return_products as $item)
                    @if($item->bill_products)

                        <tr>
                            <td>{{$item->bill_products->product_date->product_date->product->item->name}}</td>
                            <td>{{$item->amount}}</td>
                            <td>{{$item->quantity}}</td>
    {{--                        <td>{{$item->bill_products->product_discount}}</td>--}}

                        </tr>
                    @endif
                @endforeach
            </table>
            <hr>
{{--            <span style="float:left;">{{$find->total_before_tax}} ر.س</span><span style="float:right;">اجمالي قبل الضريبة</span>--}}
{{--            <br>--}}
{{--            <span style="float:left;">{{$find->total_before_tax}} ر.س</span><span style="float:right;"> فرعي</span>--}}
{{--            <br>--}}
{{--            <span style="float:left;">{{$find->date}} </span><span style="float:right;">التاريخ</span>--}}
            {{--            <span style="float:left;">{{$find->date}}</span><span style="float:right;">التاريخ</span>--}}
{{--            <br>--}}
            <span >الاجمالي</span>      <span>{{$find->total_amount}} ر.س</span>
            <br>
            <br>
            <hr>
            <span>رقم الضريبي: 300668772300003</span>
            <br>
            <span>  رقم التواصل: 0172228534</span>
            <br>
            <span>  حي الضيافة -   مركز الدكتور عبدالكريم شكري</span>
            <br>
            <hr>

            {{--            <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($find->pricelist_number, 'C39','2','30')}}" alt="barcode" />--}}
        </div>
    </center>
</div>
</body>





