@extends('doctor.layouts.header')

@section('content')

     
  <div class="analytics-sparkle-area">
            <div class="container-fluid">
              <br>
  <a href="{{url()->previous()}}" type="button" class="btn btn-info" >رجوع</a>
      <br><br>

<div class="panel panel-default">
  <div class="panel-heading">اضافة وصفة طبية</div>
  <div class="panel-body">
<div class="row">

<div class="col-md-4">
    <div class="form-group">
      <label for="email">رقم الملف</label><br>
       <input type="text" class="form-control" value="{{$pres->patient->folder_number}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">اسم المريض</label><br>
       <input type="text" class="form-control" value="{{$pres->patient->patient_name}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">رقم الهاتف</label><br>
       <input type="text" class="form-control" value="{{$pres->patient->phone}}" disabled>
    </div>
</div>

<div class="col-md-4">
  <div class="form-group">
    <label for="email">إجمالي الاصناف</label>
    <input type="number" class="form-control" value="{{count($pres->items)}}" disabled>
  </div>
</div>

<div class="col-md-4">
  <div class="form-group">
    <label for="email">التاريخ</label>
    <input type="text" class="form-control" value="{{$pres->created_at}}" disabled>
  </div>
</div>

</div>


   <br><br>
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
    
    <div class="row">
       <div class="col-md-6">
        <img src="{{Storage::url('uploads/'.$pres->doctor->signature)}}" />
       </div>
    </div>
</div>
</div>
<br>



</div>

<div class="row">
   <div class="col-md-6">
    
</div>
</div>

</div>
</div>

</div>

</div>



@endsection

    