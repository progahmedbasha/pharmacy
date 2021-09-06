@extends('doctor.layouts.header')

@section('content')

     
        <div class="analytics-sparkle-area">
            <div class="container-fluid">
			<br>
			قائمة الوصفات الطبية: <a href="{{url('addmedicaldes')}}" class="btn btn-success">اضافة وصفة جديدة</a>
			<br><br>

<br>
<div class="panel panel-default">
  <div class="panel-body">

  <div class="row">
      <div class="col-md-4">
      <form method="get" class="form-inline" action="{{url('medicaldesc')}}/{{$paginationVal}}">
     <input class="form-control input-lg" name="search_val" type="text" required>
      <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i></button>
     <a href="{{url('medicaldesc')}}/{{$paginationVal}}" class="btn btn-danger" style="margin-top:0px;"><i class="fa fa-times"></i></a>
   </form>
</div>
<div class="col-md-2">  
<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">عدد الصفوف : {{$paginationVal}}
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a  href="{{url('medicaldesc')}}/10">10</a></li>
    <li><a  href="{{url('medicaldesc')}}/25">25</a></li>
    <li><a  href="{{url('medicaldesc')}}/50">50</a></li>
    <li><a  href="{{url('medicaldesc')}}/100">100</a></li>
  </ul>
</div>
</div>
<div class="col-md-2">
<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">رقم الصفحة : {{$pres->currentPage()}}
  <span class="caret"></span></button>
  <ul class="dropdown-menu" style="overflow-y: scroll;height:200px;">
    @for($i=1; $i<=$pres->lastPage();$i++)
    <li><a  href="{{url('medicaldesc')}}/{{$paginationVal}}?page={{$i}}">{{$i}}</a></li>
    @endfor
  </ul>
</div>
</div>
<div class="col-md-4">
      <form method="get" class="form-inline" action="{{url('medicaldesc')}}/{{$paginationVal}}">
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
       <!-- <th>{{ __('doctor.doc_account_num') }}</th>-->
        <th>رقم الملف</th>
        <th>اسم المريض</th>
        <th>عدد الاصناف</th>
        <th>التاريخ</th>
    		<th>الاجراءات</th>
      </tr>
    </thead>
    <tbody>
      @foreach($pres as $index=>$value)
      <tr>
        <td>{{$index+1}}</td>
		    <td>{{$value->patient->folder_number}}</td>
        <td>{{$value->patient->patient_name}}</td>
        <td>{{count($value->items)}}</td>
        <td>{{$value->created_at}}</td>
        <td><a href="{{url('medicaldescdetail')}}/{{$value->id}}" class="btn btn-info">
            <i class="fa fa-eye" aria-hidden="true"></i></a></td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
</div>
</div>


            </div>
        </div>


    @endsection

    