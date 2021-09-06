@extends('admin.layouts.header')

@section('content')

     
        <div class="analytics-sparkle-area">
            <div class="container-fluid">
			<br>
			{{ __('supplier.supp_list') }}: <a href="{{url('addsupplier')}}" class="btn btn-success">{{ __('supplier.add_supp') }}</a>
			<br><br>
			<div class="row">
			<div class="col-md-3">
			<b>{{ __('supplier.supp_count') }}</b> <span style="color:green;font-size:16px;">{{count($suppliers)}}</span>
			</div>
			<div class="col-md-3">
			<b>{{ __('supplier.total_buy') }}</b> <span style="color:green;font-size:16px;">500</span>
			</div>
			</div>
<br>
<div class="panel panel-default">
  <div class="panel-body">
<div class="row">
    <div class="col-md-6">
      <form method="get" class="form-inline" action="{{url('supplierlist')}}/{{$paginationVal}}">
          <input class="form-control input-lg" name="search" type="text" >
          <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i></button>
          <a href="{{url('supplierlist')}}/{{$paginationVal}}" class="btn btn-danger" style="margin-top:0px;"><i class="fa fa-times"></i></a>
      </form>
</div>




        <div class="col-md-3">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">عدد الصفوف : {{$paginationVal}}
                    <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a  href="{{url('supplierlist')}}/10">10</a></li>
                    <li><a  href="{{url('supplierlist')}}/25">25</a></li>
                    <li><a  href="{{url('supplierlist')}}/50">50</a></li>
                    <li><a  href="{{url('supplierlist')}}/100">100</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-2">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">رقم الصفحة : {{$suppliers->currentPage()}}
                    <span class="caret"></span></button>
                <ul class="dropdown-menu" style="overflow-y: scroll;height:200px;">
                    @for($i=1; $i<=$suppliers->lastPage();$i++)
                        <li><a  href="{{url('supplierlist')}}/{{$paginationVal}}?page={{$i}}">{{$i}}</a></li>
                    @endfor
                </ul>
            </div>
        </div>
</div>
    <div class="table-responsive">
<table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>{{ __('supplier.supp_account_num') }}</th>
        <th>{{ __('supplier.supp_name') }}</th>
    		<th>{{ __('supplier.created_by') }}</th>
    		<th>{{ __('supplier.created_at') }}</th>
    		<th>{{ __('supplier.supp_type') }}</th>
    		<th>{{ __('supplier.bill_count') }}</th>
    		<th>{{ __('supplier.total_amount') }}</th>
    		<th>{{ __('supplier.total_supp_pay') }}</th>
    		<th>{{ __('supplier.total_supp_remaind') }}</th>
    		<th>{{ __('supplier.status') }}</th>
    		<th>{{ __('supplier.settings') }}</th>
      </tr>
    </thead>
    <tbody>
        @foreach($suppliers as $index=>$supplier)
      <tr>
        <td>{{$index+1}}</td>
        <td>{{$supplier->tree->id_code}}</td>
		<td>{{$supplier->name}}</td>
        <td>{{$supplier->user->name}}</td>
        <td>{{$supplier->created_at}}</td>
        @if($supplier->type == 0)
		  <td>{{ __('supplier.cash') }}</td>
        @else
            <td>{{ __('supplier.postponed') }}</td>
        @endif
		<td>20</td>
		<td>100</td>
        <td>100</td>
        <td>0</td>
		<td>{{$supplier->activation->activation}}</td>
        <td><a href="{{url('supplierdetail')}}/{{$supplier->id}}" class="btn btn-info">
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

    