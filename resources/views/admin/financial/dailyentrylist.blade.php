@extends('admin.layouts.header')

@section('content')

     
        <div class="analytics-sparkle-area">
            <div class="container-fluid">
			<br>
			القيود اليومية: <a href="{{url('dailyentry')}}" class="btn btn-success">إنشاء قيد</a>
			<br><br>
 <iframe id="iframe" src="" style="display:none;"></iframe>


<div class="panel panel-default">
  <div class="panel-body">

    <div class="row">

      <div class="col-md-4">
      <form method="get" class="form-inline" action="{{url('dailyentrylist')}}/{{$paginationVal}}">
     <input class="form-control" name="search_val" type="text" required>
     <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i></button>
     <a href="{{url('dailyentrylist')}}/{{$paginationVal}}" class="btn btn-danger" style="margin-top:0px;"><i class="fa fa-times"></i></a>
   </form>
</div>


<div class="col-md-2">  
<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">عدد الصفوف : {{$paginationVal}}
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a  href="{{url('dailyentrylist')}}/10">10</a></li>
    <li><a  href="{{url('dailyentrylist')}}/25">25</a></li>
    <li><a  href="{{url('dailyentrylist')}}/50">50</a></li>
    <li><a  href="{{url('dailyentrylist')}}/100">100</a></li>
  </ul>
</div>
</div>
<div class="col-md-2">
<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">رقم الصفحة : {{$entries->currentPage()}}
  <span class="caret"></span></button>
  <ul class="dropdown-menu" style="overflow-y: scroll;height:200px;">
    @for($i=1; $i<=$entries->lastPage();$i++)
    <li><a  href="{{url('dailyentrylist')}}/{{$paginationVal}}?page={{$i}}">{{$i}}</a></li>
    @endfor
  </ul>
</div>
</div>
<div class="col-md-4">
      <form method="get" class="form-inline" action="{{url('dailyentrylist')}}/{{$paginationVal}}">
     من:&nbsp;<input  name="date_from" type="date" required><br>
     إلي: <input  name="date_to" type="date" required>
     <button type="submit">بحث</button>
     <!--<a href="{{url('dailyentrylist')}}/{{$paginationVal}}" class="btn btn-danger btn-xs" style="margin-top:0px;"><i class="fa fa-times"></i></a>-->
   </form>
</div>
</div>
<br>
<div class="table-responsive">
<table class="table table-bordered" >
    <thead>
      <tr>
        <th>#</th>
        <th>التاريخ</th>
        <th>العنوان</th>
		<th>النوع</th>
		<th>الوصف</th>
		<th>الاجراءات</th>
      </tr>
    </thead>
    <tbody>
        @foreach($entries as $index=>$value)
      <tr>
        <td>{{$index+1}}</td>
        <td>{{$value->date}}</td>
		<td>{{$value->title}}</td>
        @if($value->type == 0)
		<td>يدوي</td>
        @else
        <td>آلي</td>
        @endif
        <td>{{$value->description}}</td>
		<td><a href="{{url('dailyentrydetail')}}/{{$value->id}}" class="btn btn-info">
            <i class="fa fa-eye" aria-hidden="true"></i></a>
            <button type="button" class="btn btn-success"  style="margin-top: 15px;" onclick='openmodle("{{url('printdailyentry')}}/{{ $value->id }}")'>
                <i class="fa fa-print" aria-hidden="true"></i></button>
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


<script>
$(document).ready(function() {
    $('#example').DataTable();
} );

  function openmodle(url){
    document.getElementById("iframe").src=url;
  }
</script>
    @endsection

    