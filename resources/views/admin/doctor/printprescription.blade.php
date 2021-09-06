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
  @media screen {
      div#Footer {
          display: none;
      }
  }
  @media print {
      div#Footer {
          position: fixed;
          bottom: 0;
      }
  }
</style>
</head>

    <body onload="window.print()">



            <div class="container-fluid">

                <div id="Header" >
                        <br>
                      <center>
                         <img class="main-logo" src="{{url('img/Logo.png')}}" alt="" width="200px"><br>
                     <h3>تفاصيل الوصفة الطبية<br>{{$pres->created_at}}</h3>
                   </center>
                </div>
                <br><br>

<div class="panel panel-default" >
  <div class="panel-heading">بيانات الطبيب</div>
</div>

<table class="table table-bordered">
  <tr>
    <td>اسم الطبيب</td>
    <td>نوع العيادة</td>
  </tr>
  <tr>
    <td>{{$pres->doctor->name}}</td>
    <td>{{$pres->doctor->clinic_type}}</td>
  </tr>
</table>




<div class="panel panel-default">
  <div class="panel-heading">بيانات المريض</div>
</div>

<table class="table table-bordered">
  <tr>
    <td>رقم الملف</td>
    <td>اسم المريض</td>
    <td>رقم الهاتف</td>
     <td>إجمالي الاصناف</td>
      <td>التاريخ</td>
  </tr>
  <tr>
    <td>{{$pres->patient->folder_number}}</td>
    <td>{{$pres->patient->patient_name}}</td>
    <td>{{$pres->patient->phone}}</td>
    <td>{{count($pres->items)}}</td>
    <td>{{$pres->created_at}}</td>
  </tr>
</table>



<div class="panel panel-default">
  <div class="panel-heading">بيانات وصفة طبية</div>
  <div class="panel-body">
<br>
<div class="table-responsive">
        <table class="table table-bordered table-striped main" id="dynamicTable">
          <tr>
            <th>#</th>
            <th style="width:220px;">اســـم المنتـــج</th>
            <th style="width:120px;">الكمية المطلوبة</th>
            <th>ملاحظات</th>
          </tr>
          @foreach($pres->items as $index=>$value)
            <tr>
              <th>{{$index+1}}</th>
              <th>{{$value->item->name}}</th>
              <th>{{$value->quantity}}</th>
              <th>{{$value->notes}}</th>
            </tr>
          @endforeach
        </table>
    </div>


</div>
</div>
<br>
                <div>
<center>
        <div id="Footer">

                            <center style="display: inline-block;text-align: center">
                            <br>
                                      <span>رقم الضريبي: 75757687678</span>
                                      <br>
                                      <span>055889798789 - 05513289787</span>
                                      <br>
                                      <span>المملكة العربية السعودية</span>
                                      <br>

                                      <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($pres->id, 'C39','2','30')}}" alt="barcode" />
                                    </center>
                                <img style="display:inline-block;" width="400px" src="{{Storage::url('uploads/'.$pres->doctor->signature)}}">

                            </div>
                    </center>
                </div>
</div>






</body>
</html>

