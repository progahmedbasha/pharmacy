
<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<style type="text/css">
  th{
    text-align:right;
  }
</style>
</head>

    <body onload="window.print()">
      <div class="container">
        <br><br>
        <center>
                <img class="main-logo" src="{{url('img/Logo.png')}}" alt="" width="200px"><br>
        <br><br>
</center>
   <div class="panel panel-default">
    <div class="panel-heading">تفاصيل الفاتورة رقم : {{$bill->bill_number}}
    <span style="float:left;">تاريخ الفاتورة: {{$bill->bill_date}}</span>
    </div>
    <div class="panel-body">
<br>
<table class="table table-bordered">
  <tr>
    <td>أنشيء بواسطة</td>
    <td>المورد</td>
    <td>رقم حساب المورد</td>
    <td>رصيد المورد</td>
    <td>نوع الفاتورة</td>
    <td>مندوب المشتريات</td>
  </tr>
  <tr>
    <td>{{$bill->user->name}}</td>
    <td>{{$bill->supplier->name}}</td>
    <td>{{$bill->supplier->tree->id_code}}</td>
    <td>{{$bill->supplier->tree->balance}}</td>
    <td>
      @if($bill->supplier->type == 0)
          نقدي
        @else
          آجل
          @endif
    </td>
    <td>
      @if($bill->employee != null)
           {{$bill->employee->name}}
          @else
            -
          @endif
    </td>
  </tr>
</table>


<table class="table table-bordered">
  <tr><td>المخزن</td><td>{{$bill->store->store_name}}</td></tr>
  <tr><td>إجمالي الاصناف</td><td>{{count($bill->bill_products)}}</td></tr>
  <tr><td>إجمالي الخصم</td><td>{{$bill->total_discount}}</td></tr>
  <tr><td>الإجمالي قبل الضريبة</td><td>{{$bill->total_before_tax}}</td></tr>
  <tr><td>إجمالي الضريبة</td><td>{{$bill->total_tax}}</td></tr>
  <tr><td>الإجمالي النهائي</td><td>{{$bill->total_final}}</td></tr>
  <tr><td>طريقة الدفع</td>
      <td>@if($bill->pay_way == 0)كاش @elseif($bill->pay_way == 1)شبكة @else متعدد @endif</td></tr>

<tr><td>تاريخ الاستحقاق</td><td>{{$bill->due_date}}</td></tr>
<tr><td>حالة الدفع</td><td>@if($bill->is_paid == 1)مكتمل الدفع @else غير مكتمل الدفع @endif</td></tr>
</table>





        <table class="table table-bordered table-striped main" id="dynamicTable">  
          <tr>
           <th style="width:300px;">اســـم المنتـــج</th>
                <th style="width:120px;">تاريخ الإنتاج</th>
                <th style="width:120px;">تاريخ الإنتهاء</th>
                <th>السعر</th>
                <!--<th>الوحدة</th>-->
        <th>الكمية</th>
                <th>الخصم</th>
        <th>قيمة الضريبة</th>
        <th>الاجمالي</th>
          </tr>
          @foreach($bill->bill_products as $item)
            <tr>  
              <td>{{$item->product_date->product->item->name}}</td> 
              <td>{{$item->product_date->production_date}}</td> 
              <td>{{$item->product_date->expire_date}}</td> 
              <td>{{$item->product_date->cost}}</td> 
              <td>{{$item->quantity}}</td>  
              <td>{{$item->product_discount}}</td> 
              <td>{{$item->tax_value}}</td> 
              <td>{{$item->total_price}}</td> 
              
            </tr> 
          @endforeach 
        </table> 

  
</div>
</div>

<center>
<br>
          <span>رقم الضريبي: 75757687678</span>
          <br>
          <span>055889798789 - 05513289787</span>
          <br>
          <span>المملكة العربية السعودية</span>
          <br>
          <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($bill->bill_number, 'C39','2','30')}}" alt="barcode" />
        </center>
</div>
</body>


  

    
