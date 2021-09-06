@extends('admin.layouts.header')

@section('content')

     
        <div class="analytics-sparkle-area">
            <div class="container-fluid">			
			<br><br>

      <iframe id="iframe" src="" style="display:none;"></iframe>

			<div class="row">
			<div class="col-md-3">
			<b>اجمالي عدد الفواتير</b> <span style="color:green;font-size:16px;">{{count($bills)}}</span>
			</div>
			<div class="col-md-3">
			<b>اجمالي المبيعات</b> <span style="color:green;font-size:16px;">{{round($total_final,2)}}</span>
			</div>
			<div class="col-md-3">
			<b>اجمالي المدفوع</b> <span style="color:green;font-size:16px;">{{round($paid_amount,2)}}</span>
			</div>
			<div class="col-md-3">
			<b>اجمالي المتبقي</b> <span style="color:green;font-size:16px;">{{round($remaining_amount,2)}}</span>
			</div>
			</div>
<br>

<div class="panel panel-default">
  <div class="panel-body">

  	<div class="row">
  	<div class="col-md-4">
      <form method="get" class="form-inline" action="{{url('managebill')}}/{{$paginationVal}}">
  	 <input class="form-control input-lg" name="search_val" type="text" required>
      <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i></button>
     <a href="{{url('managebill')}}/{{$paginationVal}}" class="btn btn-danger" style="margin-top:0px;"><i class="fa fa-times"></i></a>
   </form>
</div>

<div class="col-md-2">  
<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">عدد الصفوف : {{$paginationVal}}
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a  href="{{url('managebill')}}/10">10</a></li>
    <li><a  href="{{url('managebill')}}/25">25</a></li>
    <li><a  href="{{url('managebill')}}/50">50</a></li>
    <li><a  href="{{url('managebill')}}/100">100</a></li>
  </ul>
</div>
</div>
<div class="col-md-2">
<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">رقم الصفحة : {{$bills->currentPage()}}
  <span class="caret"></span></button>
  <ul class="dropdown-menu" style="overflow-y: scroll;height:200px;">
  	@for($i=1; $i<=$bills->lastPage();$i++)
    <li><a  href="{{url('managebill')}}/{{$paginationVal}}?page={{$i}}">{{$i}}</a></li>
    @endfor
  </ul>
</div>
</div>
<div class="col-md-4">
      <form method="get" class="form-inline" action="{{url('managebill')}}/{{$paginationVal}}">
  	 من:&nbsp;<input  name="date_from" type="date" required><br>
  	 إلي: <input  name="date_to" type="date" required>
     <button type="submit">بحث</button>
   </form>
</div>
</div>
<br>

<div class="table-responsive">
<table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>رقم الفاتورة</th>
        <th>إسم الطبيب</th>
        <th>رقم ملف المريض</th>
        <th>إسم المريض</th>
        <th>تاريخ الفاتورة</th>
    		<th>أنشئ بواسطة</th>
    		<th>اجمالي المبلغ</th>
    		<th>المدفوع</th>
    		<th>المتبقي</th>
    		<th>الحالة</th>
    		<th>الاجراءات</th>
      </tr>
    </thead>
    <tbody>
     @foreach($bills as $index=>$value)
      <tr>
        <td>{{$index+1}}</td>
        <td>{{$value->bill_number}}</td>
        <td>{{$value->prescription_bills->prescription->doctor->name}}</td>
        <td>{{$value->prescription_bills->prescription->patient->folder_number}}</td>
        <td>{{$value->prescription_bills->prescription->patient->patient_name}}</td>
        <td>{{$value->bill_date}}</td>
		<td>{{$value->user->name}}</td>
		<td>{{$value->total_final}}</td>
        <td>{{round($value->paid_amount,2)}}</td>
        <td>{{$value->remaining_amount}}</td>
        @if($value->is_paid == 1)
			<td>مكتمل</td>
		@else
			<td>غير مكتمل</td>
		@endif
        <td> <a href="{{url('salebilldetail')}}/{{$value->id}}" class="btn btn-info">
            <i class="fa fa-eye" aria-hidden="true"></i></a>

            <button type="button" class="btn btn-success"  style="margin-top: 15px;" onclick='openmodle("{{url('printsalebill')}}/{{ $value->id }}")'>
                <i class="fa fa-print" aria-hidden="true"></i></button>

            <a href="{{url('returnbillaction')}}/{{$value->id}}" class="btn btn-danger">
            <i class="fa fa-reply-all" aria-hidden="true"></i></a>


          </td>

      </tr>
      @endforeach
    </tbody>
  </table>
</div>
</div>
</div>
            </div>
        </div>

<script type="text/javascript">
  function openmodle(url){
    document.getElementById("iframe").src=url;
  }
</script>


    @endsection

    