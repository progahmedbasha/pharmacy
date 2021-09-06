@extends('admin.layouts.header')

@section('content')

     
        <div class="analytics-sparkle-area">
            <div class="container-fluid">
			<br>
			ادارة الموظفين: <a href="{{url('addemployee')}}" class="btn btn-success">اضافة موظف</a>
			<br><br>
			<div class="row">
			<div class="col-md-3">
			<b>اجمالي عدد الموظفين</b> <span style="color:green;font-size:16px;">{{count($employees)}}</span>
			</div>
			<div class="col-md-3">
			<b>اجمالي المرتبات</b> <span style="color:green;font-size:16px;">500</span>
			</div>
			</div>
<br>
<div class="panel panel-default">
  <div class="panel-body">
        <div class="row">
    <div class="col-md-6">
      <form method="get" class="form-inline" action="{{url('manageemployee')}}/{{$paginationVal}}">
          <input class="form-control input-lg" name="search" type="text" >
          <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i></button>
          <a href="{{url('manageemployee')}}/{{$paginationVal}}" class="btn btn-danger" style="margin-top:0px;"><i class="fa fa-times"></i></a>
      </form>
</div>
      <div class="row">
<div class="col-md-2">
<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">عدد الصفوف : {{$paginationVal}}
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a  href="{{url('manageemployee')}}/10">10</a></li>
    <li><a  href="{{url('manageemployee')}}/25">25</a></li>
    <li><a  href="{{url('manageemployee')}}/50">50</a></li>
    <li><a  href="{{url('manageemployee')}}/100">100</a></li>
  </ul>
</div>
</div>
<div class="col-md-2">
<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">رقم الصفحة : {{$employees->currentPage()}}
  <span class="caret"></span></button>
  <ul class="dropdown-menu" style="overflow-y: scroll;height:200px;">
    @for($i=1; $i<=$employees->lastPage();$i++)
    <li><a  href="{{url('manageemployee')}}/{{$paginationVal}}?page={{$i}}">{{$i}}</a></li>
    @endfor
  </ul>
</div>
</div>
</div>
<br>
<div class="table-responsive">
<table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>كودالموظف</th>
		<th>إسم الموظف</th>
		<th>تاريخ الإلتحاق</th>
		<th>إدارة الموظف</th>
		<th>قيمة الراتب</th>
		<th>الهدف</th>
		<th>العمولة</th>
		<th>نوع الدوام</th>
		<th>الحالة</th>
		<th>الاجراءات</th>
      </tr>
    </thead>
    <tbody>
        @foreach($employees as $index=>$employee)
            <tr>
                <td>{{$index+1}}</td>
                <td>{{$employee->code}}</td>
        		<td>{{$employee->name}}</td>
                <td>{{$employee->hiring_date}}</td>
        		<td>{{$employee->department->department}}</td>
        		<td>20</td>
        		<td>100</td>
                <td>100</td>
                <td>{{$employee->period_type->period_type}}</td>
        		<td>{{$employee->activation->activation}}</td>
                <td>
                <a href="{{url('employeedetail')}}/{{$employee->id}}" class="btn btn-info">
            <i class="fa fa-eye" aria-hidden="true"></i></a>
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


    @endsection

    