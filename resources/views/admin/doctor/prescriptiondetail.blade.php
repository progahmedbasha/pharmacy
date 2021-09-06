@extends('admin.layouts.header')

@section('content')

     
 
            <div class="container-fluid">
              <br>
              <button type="button" class="btn btn-success"   onclick='openmodle("{{url('printprescription')}}/{{ $pres->id }}")'>
                <i class="fa fa-print" aria-hidden="true"></i> طباعة الوصفة الطبية</button>
            @if($pres->is_bill == 0)
          <a href="{{url('prescriptionbill')}}/{{ $pres->id }}" class="btn btn-info"   >
              <i class="fa fa-link" aria-hidden="true"></i> إنشاء فاتروة للوصفة لطبية</a>
              @endif
  <a href="{{url()->previous()}}" type="button" class="btn btn-primary" >رجوع</a>
      <br><br>

<iframe id="iframe" src="" style="display:none;"></iframe>

<div class="panel panel-default">
  <div class="panel-heading">بيانات الطبيب</div>
  <div class="panel-body">
<div class="row">

<div class="col-md-4">
    <div class="form-group">
      <label for="email">اسم الطبيب</label><br>
       <input type="text" class="form-control" value="{{$pres->doctor->name}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">البريد الالكتروني</label><br>
       <input type="text" class="form-control" value="{{$pres->doctor->email}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">رقم الهاتف</label><br>
       <input type="text" class="form-control" value="{{$pres->doctor->phone}}" disabled>
    </div>
</div>


</div>

</div>
</div>


<div class="panel panel-default">
  <div class="panel-heading">بيانات المريض</div>
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

</div>
</div>



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

</div>




<script type="text/javascript">
  function openmodle(url){
    document.getElementById("iframe").src=url;
  }
</script>

@endsection

    