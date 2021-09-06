@extends('admin.layouts.header')

@section('content')

    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet">

        <div class="analytics-sparkle-area">
            <div class="container-fluid">
			<br>
			إرجاع الفواتير: <!--<button type="button" class="btn btn-success">إنشاء فاتورة</button>-->
			<br><br>
			<div class="row">
			<div class="col-md-3">
			<b>اجمالي عدد الفواتير</b> <span style="color:green;font-size:16px;">3</span>
			</div>
			<div class="col-md-3">
			<b>اجمالي مبلغ الفواتير</b> <span style="color:green;font-size:16px;">500</span>
			</div>
			<div class="col-md-2">
			<b> اجمالي المرتجع</b> <span style="color:green;font-size:16px;">300</span>
			</div>
                <div class="col-md-4">
                    <form method="get" class="form-inline" action="{{url('purchasereturnbill')}}">
                        من:&nbsp;<input  name="date_from" type="date" value="{{date('Y-m-d', strtotime(date('Y-m-d'). ' - 30 days'))}}" required><br>
                        إلي: <input  name="date_to" value="{{date('Y-m-d')}}" type="date" required>
                        <button type="submit">بحث</button>
                    </form>
                </div>
    <div class="row">
    <div class="col-md-6">
      <form method="get" class="form-inline" action="{{url('purchasereturnbill')}}/{{$paginationVal}}">
          <input class="form-control input-lg" name="search" type="text" >
          <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i></button>
          <a href="{{url('purchasereturnbill')}}/{{$paginationVal}}" class="btn btn-danger" style="margin-top:0px;"><i class="fa fa-times"></i></a>
      </form>
</div>
<div class="row">
<div class="col-md-2">
<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">عدد الصفوف : {{$paginationVal}}
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a  href="{{url('purchasereturnbill')}}/10">10</a></li>
    <li><a  href="{{url('purchasereturnbill')}}/25">25</a></li>
    <li><a  href="{{url('purchasereturnbill')}}/50">50</a></li>
    <li><a  href="{{url('purchasereturnbill')}}/100">100</a></li>
  </ul>
</div>
</div>
<div class="col-md-2">
<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">رقم الصفحة : {{$return_bill->currentPage()}}
  <span class="caret"></span></button>
  <ul class="dropdown-menu" style="overflow-y: scroll;height:200px;">
    @for($i=1; $i<=$return_bill->lastPage();$i++)
    <li><a  href="{{url('purchasereturnbill')}}/{{$paginationVal}}?page={{$i}}">{{$i}}</a></li>
    @endfor
  </ul>
</div>
</div>
			</div>
<br>

<div class="panel panel-default">

  <div class="panel-body">

<div class="table-responsive">


<table  class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>رقم الإرجاع</th>
        <th>تاريخ الإرجاع</th>
    		<th>رقم فاتورة المشتريات</th>
    		<th>المورد</th>
    		<th>أنشئ بواسطة</th>
    		<th>اجمالي المبلغ</th>
    		<th>مبلغ الارجاع</th>
        <th>الحالة</th>
    		<th>الاجراءات</th>
      </tr>
    </thead>
    <tbody>
    	@foreach($return_bill as $index=>$value)
      <tr>
        <td>{{$index+1}}</td>
        <td>{{$value->return_number}}</td>
        <td>{{$value->created_at}}</td>
    		<td>{{$value->bill->bill_number}}</td>
    		<td>{{$value->bill->supplier->name}}</td>
    		<td>{{$value->user->name}}</td>
    		<td>{{$value->bill->total_final}}</td>
        <td>{{$value->total_amount}}</td>
        @if($value->isClosed == 0)
          <td>غير مغلق</td>
        @else
          <td>مغلق</td>
        @endif

        <td><a href="{{url('purchasereturnbilldetail')}}/{{$value->id}}" class="btn btn-info">
            <i class="fa fa-eye" aria-hidden="true"></i></a></td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>header.blade.php</td>
    </tr>
    </tfoot>
  </table>
    </div>
  </div>
  </div>
            </div>
        </div>


   

    @endsection

