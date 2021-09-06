
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
   <div class="analytics-sparkle-area">
            <div class="container-fluid">
                <br><br>
                <center>
                <img class="main-logo" src="{{url('img/Logo.png')}}" alt="" width="200px"><br>
        <br><br>
</center>
      

<div class="panel panel-default">
     <div class="panel-heading">تفاصيل القيد: (#{{$entry->id}})
        
  <span style="float:left;">تاريخ القيد: {{$entry->date}}</span>
        </div>
  <div class="panel-body">
     

<div class="row">

<div class="col-md-6">
    <div class="form-group">
      <label for="email">عنوان القيد</label>
      <input type="text" class="form-control" value="{{$entry->title}}" disabled>
    </div>
</div>

<div class="col-md-12">
    <div class="form-group">
      <label for="pwd">الوصف</label>
      <textarea rows="4" class="form-control" disabled>{{$entry->description}}</textarea>
    </div>
</div>


</div>


<div class="row">
 <div class="col-sm-12">
<br>
<div class="table-responsive">
        <table class="table table-bordered table-striped" id="dynamicTable">  
            <tr>
              <th>اسم الحساب </th>
              <th>الوصف</th>
              <th>دائن </th>
              <th>مدين </th>
            </tr>
            @foreach($entry->actions as $acction)
                <tr>  
                  <td>{{$acction->tree->name}}</td>  
                  <td>{{$acction->description}}</td>  
                  <td>{{$acction->credit}}</td>  
                  <td>{{$acction->debit}}</td> 
                </tr>
            @endforeach
        </table> 
    </div>
        
</div>
</div>

<table width="100%">
  <tr>
    <td>
    <div class="well well-sm" style="background-color: #8dc1ff !important;">
<span>دائن</span><input type="text" value="{{$entry->actions->sum('credit')}}" style="background: transparent; border: none;text-align:center;" disabled/>
 </div>
</td>

<td>


    <div class="well well-sm" style="background-color: #ffc6b9 !important;">
<span>مدين</span><input type="text" value="{{$entry->actions->sum('debit')}}" style="background: transparent; border: none;text-align:center;" disabled/>
</div>
</td>
</tr>
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
          <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($entry->id, 'C39','2','30')}}" alt="barcode" />
        </center>

            </div>
        </div>
</body>


  

    
