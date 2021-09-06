@extends('admin.layouts.header')

@section('content')

     
        <div class="analytics-sparkle-area">
            <div class="container-fluid">
			<br>
			ادارة المستودعات:<a href="{{url('addstore')}}" class="btn btn-success">اضافة مستودع</a>
			<br><br>
			<div class="row">
			<div class="col-md-3">
			<b>اجمالي عدد المخازن</b> <span style="color:green;font-size:16px;">{{count($stores)}}</span>
			</div>
			<div class="col-md-3">
			<b>اجمالي عدد الاصناف </b> <span style="color:green;font-size:16px;">500</span>
			</div>
			<div class="col-md-3">
			<b>اجمالي تكلفة المنتجات  </b> <span style="color:green;font-size:16px;">500</span>
			</div>
			</div>
<br>
<div class="panel panel-default">
  <div class="panel-body">
    <div class="row">
    <div class="col-md-6">
      <form method="get" class="form-inline" action="{{url('storemanage')}}/{{$paginationVal}}">
          <input class="form-control input-lg" name="search" type="text" >
          <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i></button>
          <a href="{{url('storemanage')}}/{{$paginationVal}}" class="btn btn-danger" style="margin-top:0px;"><i class="fa fa-times"></i></a>
      </form>
</div>




        <div class="col-md-3">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">عدد الصفوف : {{$paginationVal}}
                    <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a  href="{{url('storemanage')}}/10">10</a></li>
                    <li><a  href="{{url('storemanage')}}/25">25</a></li>
                    <li><a  href="{{url('storemanage')}}/50">50</a></li>
                    <li><a  href="{{url('storemanage')}}/100">100</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-2">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">رقم الصفحة : {{$stores->currentPage()}}
                    <span class="caret"></span></button>
                <ul class="dropdown-menu" style="overflow-y: scroll;height:200px;">
                    @for($i=1; $i<=$stores->lastPage();$i++)
                        <li><a  href="{{url('storemanage')}}/{{$paginationVal}}?page={{$i}}">{{$i}}</a></li>
                    @endfor
                </ul>
            </div>
        </div>
</div><br>
<div class="table-responsive">
<table class="table table-bordered" >
    <thead>
      <tr>
        <th>#</th>
        <th>رقم المخزن </th>
		<th>اسم المخزن</th>
		<th>العنوان </th>
		<th>تاريخ الاضافة</th>
		<th>عدد الاصناف</th>
		<th>التكلفة </th>
		<th>المستخدم </th>
		<th>الاجراءات</th>
      </tr>
    </thead>
    <tbody>
        @foreach($stores as $index=>$store)
      <tr>
        <td>{{$index+1}}</td>
        <td>{{$store->store_code}}</td>
		<td>{{$store->store_name}}</td>
        <td>{{$store->address}}</td>
		<td>{{$store->created_at}}</td>
		<td>اجل</td>
		<td>500</td>
		<td>500</td>
        <td>
            <a href="{{url('storedetail')}}/{{$store->id}}" class="btn btn-info">
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

    