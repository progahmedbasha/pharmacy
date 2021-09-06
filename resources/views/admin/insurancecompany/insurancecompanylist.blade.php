@extends('admin.layouts.header')

@section('content')

     
        <div class="analytics-sparkle-area">
            <div class="container-fluid">
			<br>
			{{ __('insurance.insur_comp') }}: <a href="{{url('addinsurancecompany')}}" type="button" class="btn btn-info">{{ __('insurance.add_comp') }}</a>
			<br><br>
			<div class="row">
			<div class="col-md-3">
			<b>{{ __('insurance.comp_count') }}</b> <span style="color:green;font-size:16px;">{{count($companies)}}</span>
			</div>
			<div class="col-md-3">
			<b>{{ __('insurance.total_bill_count') }}</b> <span style="color:green;font-size:16px;">5</span>
			</div>
            <div class="col-md-3">
            <b>{{ __('insurance.total_bill_cost') }}</b> <span style="color:green;font-size:16px;">500</span>
            </div>
			</div>
<br>

<div class="panel panel-default">
  <div class="panel-body">
    <div class="row">
    <div class="col-md-6">
      <form method="get" class="form-inline" action="{{url('insurancecompanylist')}}/{{$paginationVal}}">
          <input class="form-control input-lg" name="search" type="text" >
          <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i></button>
          <a href="{{url('insurancecompanylist')}}/{{$paginationVal}}" class="btn btn-danger" style="margin-top:0px;"><i class="fa fa-times"></i></a>
      </form>
</div>
      <div class="row">
<div class="col-md-2">
<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">عدد الصفوف : {{$paginationVal}}
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a  href="{{url('insurancecompanylist')}}/10">10</a></li>
    <li><a  href="{{url('insurancecompanylist')}}/25">25</a></li>
    <li><a  href="{{url('insurancecompanylist')}}/50">50</a></li>
    <li><a  href="{{url('insurancecompanylist')}}/100">100</a></li>
  </ul>
</div>
</div>
<div class="col-md-2">
<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">رقم الصفحة : {{$companies->currentPage()}}
  <span class="caret"></span></button>
  <ul class="dropdown-menu" style="overflow-y: scroll;height:200px;">
    @for($i=1; $i<=$companies->lastPage();$i++)
    <li><a  href="{{url('insurancecompanylist')}}/{{$paginationVal}}?page={{$i}}">{{$i}}</a></li>
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
        <th>{{ __('insurance.comp_account_num') }}</th>
    		<th>{{ __('insurance.comp_name') }}</th>
    		<th>{{ __('insurance.created_at') }}</th>
    		<th>{{ __('insurance.bill_count') }}</th>
    		<th>{{ __('insurance.cost') }}</th>
    		<th>{{ __('insurance.settings') }}</th>
      </tr>
    </thead>
    <tbody>
        @foreach($companies as $index=>$company)
      <tr>
        <td>{{$index+1}}</td>
        <td>24124124</td>
		<td>{{$company->company_name}}</td>
        <td>{{$company->created_at}}</td>
		<td>10</td>
		<td>500</td>
        <td>
        <a href="{{url('insurancecompanydetail')}}/{{$company->id}}" class="btn btn-info">
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

    