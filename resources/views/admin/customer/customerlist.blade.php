@extends('admin.layouts.header')

@section('content')


        <div class="analytics-sparkle-area">
            <div class="container-fluid">
			<br>
			{{ __('customer.cus_list') }}: <a href="{{url('addcustomer')}}" class="btn btn-success">{{ __('customer.add_cus') }}</a>
			<br><br>
			<div class="row">
			<div class="col-md-3">
			<b>{{ __('customer.cus_count') }}</b> <span style="color:green;font-size:16px;">{{count($customers)}}</span>
			</div>
			<div class="col-md-3">
			<b>{{ __('customer.total_sale') }}</b> <span style="color:green;font-size:16px;">{{$total_sales}}</span>
			</div>
			</div>

<br>
<div class="panel panel-default">
  <div class="panel-body">
<div class="row">
    <div class="col-md-6">
      <form method="get" class="form-inline" action="{{url('customerlist')}}/{{$paginationVal}}">
          <input class="form-control input-lg" name="search" type="text" >
          <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i></button>
          <a href="{{url('customerlist')}}/{{$paginationVal}}" class="btn btn-danger" style="margin-top:0px;"><i class="fa fa-times"></i></a>
      </form>
</div>




        <div class="col-md-3">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">عدد الصفوف : {{$paginationVal}}
                    <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a  href="{{url('customerlist')}}/10">10</a></li>
                    <li><a  href="{{url('customerlist')}}/25">25</a></li>
                    <li><a  href="{{url('customerlist')}}/50">50</a></li>
                    <li><a  href="{{url('customerlist')}}/100">100</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-2">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">رقم الصفحة : {{$customers->currentPage()}}
                    <span class="caret"></span></button>
                <ul class="dropdown-menu" style="overflow-y: scroll;height:200px;">
                    @for($i=1; $i<=$customers->lastPage();$i++)
                        <li><a  href="{{url('customerlist')}}/{{$paginationVal}}?page={{$i}}">{{$i}}</a></li>
                    @endfor
                </ul>
            </div>
        </div>
</div>
    <div class="table-responsive">
<table class="table table-bordered" >
    <thead>
      <tr>
        <th>#</th>
        <th>{{ __('customer.cus_account_num') }}</th>
        <th>{{ __('customer.cus_name') }}</th>
		<th>{{ __('customer.created_by') }}</th>
		<th>{{ __('customer.created_at') }}</th>
		<th>{{ __('customer.cus_type') }}</th>
		<th>{{ __('customer.bill_count') }}</th>
          <th>عدد مرتجعات المبيعات</th>
		<th>قيمة المبيعات</th>
		<th>{{ __('customer.total_cus_pay') }}</th>
		<th>{{ __('customer.total_cus_remaind') }}</th>
          <th>إجمالى قيمة المرتجعات</th>
		<th>{{ __('customer.status') }}</th>
		<th>{{ __('customer.settings') }}</th>
      </tr>
    </thead>
    <tbody>
        @foreach($customers as $index=>$customer)

      <tr  @if($customer->isActive == 2)style="background: #fbd8a5" @elseif($customer->isActive == 3)style="background: rgba(255,0,0,0.42)" @endif>
        <td>{{$index+1}}</td>
        <td>{{$customer->tree->id_code}}</td>
        <td>{{$customer->name}}</td>
		<td>{{$customer->user->name}}</td>
        <td>{{$customer->created_at}}</td>
        @if($customer->type == 0)
		<td>{{ __('customer.individual') }}</td>
        @else
        <td>{{ __('customer.company') }}</td>
        @endif
		<td>{{$customer->sale_bills_count}}</td>
        <td>{{$customer->return_sale_bills_count}}</td>
		<td>{{round($customer->sale_bills_sum_total_final, 2)}}</td>
        <td>{{round($customer->sale_bills_sum_total_final - $customer->sale_bills_sum_remaining_amount, 2)}}</td>
        <td>{{round($customer->sale_bills_sum_remaining_amount, 2)}}</td>
        <td>{{round($customer->return_sale_bills_sum_total_amount, 2)}}</td>
		<td>{{$customer->activation->activation}}</td>
        <td>
            <a href="{{url('customerdetail')}}/{{$customer->id}}" class="btn btn-info">
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

