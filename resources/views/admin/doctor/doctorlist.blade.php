@extends('admin.layouts.header')

@section('content')

    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet">

        <div class="analytics-sparkle-area">
            <div class="container-fluid">
                <h2>إدارة الأطباء</h2>
			<br>
			{{ __('doctor.doc_list') }}: <a href="{{url('adddoctor')}}" class="btn btn-success">{{ __('doctor.add_doc') }}</a>
			<br><br>
			<div class="row">
			<div class="col-md-3">
			<b>{{ __('doctor.doc_count') }}</b> <span style="color:green;font-size:16px;">{{count($doctors)}}</span>
			</div>
			<!--<div class="col-md-3">
			<b>{{ __('doctor.total_buy') }}</b> <span style="color:green;font-size:16px;">500</span>
			</div>-->
			</div>
<br>
<div class="panel panel-default">
  <div class="panel-body">

    <div class="row">
    <div class="col-md-6">
      <form method="get" class="form-inline" action="{{url('doctorlist')}}/{{$paginationVal}}">
          <input class="form-control input-lg" name="search" type="text" >
          <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i></button>
          <a href="{{url('doctorlist')}}/{{$paginationVal}}" class="btn btn-danger" style="margin-top:0px;"><i class="fa fa-times"></i></a>
      </form>
</div>
      <div class="row">
<div class="col-md-2">
<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">عدد الصفوف : {{$paginationVal}}
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a  href="{{url('doctorlist')}}/10">10</a></li>
    <li><a  href="{{url('doctorlist')}}/25">25</a></li>
    <li><a  href="{{url('doctorlist')}}/50">50</a></li>
    <li><a  href="{{url('doctorlist')}}/100">100</a></li>
  </ul>
</div>
</div>
<div class="col-md-2">
<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">رقم الصفحة : {{$doctors->currentPage()}}
  <span class="caret"></span></button>
  <ul class="dropdown-menu" style="overflow-y: scroll;height:200px;">
    @for($i=1; $i<=$doctors->lastPage();$i++)
    <li><a  href="{{url('doctorlist')}}/{{$paginationVal}}?page={{$i}}">{{$i}}</a></li>
    @endfor
  </ul>
</div>
</div>
</div>
<br>

    <div class="table-responsive">
<table class="table table-bordered" >
    <thead>
      <tr>
      <th>#</th>
      <th>{{ __('doctor.doc_code') }}</th>
      <th>{{ __('doctor.doc_name') }}</th>
      <th>{{ __('doctor.email') }}</th>
      <th>{{ __('doctor.phone') }}</th>
      <th>{{ __('doctor.clinic_type') }}</th>
    	<th>{{ __('doctor.created_by') }}</th>
          <th>{{ __('doctor.signature') }}</th>
    	<th>{{ __('doctor.created_at') }}</th>
    		<!--  <th>{{ __('doctor.total_amount') }}</th>
    		<th>{{ __('doctor.total_doc_pay') }}</th>
    		<th>{{ __('doctor.total_doc_remaind') }}</th>
    		<th>{{ __('doctor.status') }}</th>-->
    		<th>{{ __('doctor.settings') }}</th>
      </tr>
    </thead>
    <tbody>
        @foreach($doctors as $index=>$doctor)
      <tr>
        <td>{{$index+1}}</td>
        <td>{{$doctor->doc_code}}</td>
		    <td>{{$doctor->name}}</td>
        <td>{{$doctor->email}}</td>
        <td>{{$doctor->phone}}</td>
        <td>{{$doctor->clinic_type}}</td>
        <td>{{$doctor->user->name}}</td>
        <td><img src="{{Storage::url('uploads/'.$doctor->signature)}}" /></td>
        <td>{{$doctor->created_at}}</td>
        <td><a href="{{url('doctordetail')}}/{{$doctor->id}}" class="btn btn-info">
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

