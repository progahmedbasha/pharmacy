@extends('admin.layouts.header')

@section('content')

    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet">

        <div class="analytics-sparkle-area">

            <div class="container-fluid">
                <h2>إرجاع الفواتير</h2>
			<br>
			إرجاع الفواتير: <a href="{{route('create_return_bill')}}" class="btn btn-success">إنشاء فاتورة</a>
			<br><br>
			<div class="row">
			<div class="col-md-3">
			<b>اجمالي عدد الفواتير</b> <span style="color:green;font-size:16px;">{{$return_bill}}</span>
			</div>
			<div class="col-md-3">
			<b>اجمالي مبلغ الفواتير</b> <span style="color:green;font-size:16px;">{{$total_final}}</span>
			</div>

			</div>

        <br>
                    

                        <div class="panel panel-default">

  <div class="panel-body">
      <div class="col-md-4">
          <form method="get" class="form-inline" action="{{url('returnbilllist')}}/{{$paginationVal}}">
              من:&nbsp;<input  name="date_from" type="date" value="@if(Request::get('date_from')){{Request::get('date_from')}} @endif" required><br>
              إلي: <input  name="date_to" value="@if(Request::get('date_to')){{Request::get('date_to')}} @endif" type="date" required>
              <button type="submit">بحث</button>
          </form>
      </div>

        <div class="col-md-4">
            <form method="get" class="form-inline" action="{{url('returnbilllist')}}/{{$paginationVal}}">
          <input class="form-control input-lg" name="search" type="text" >
          <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i></button>
          <a href="{{url('returnbilllist')}}/{{$paginationVal}}" class="btn btn-danger" style="margin-top:0px;"><i class="fa fa-times"></i></a>
      </form>
        </div>
       


      <div class="col-md-3">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">عدد الصفوف : {{$paginationVal}}
                    <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a  href="{{url('returnbilllist')}}/10">10</a></li>
                    <li><a  href="{{url('returnbilllist')}}/25">25</a></li>
                    <li><a  href="{{url('returnbilllist')}}/50">50</a></li>
                    <li><a  href="{{url('returnbilllist')}}/100">100</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-2">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">رقم الصفحة : {{$bills->currentPage()}}
                    <span class="caret"></span></button>
                <ul class="dropdown-menu" style="overflow-y: scroll;height:200px;">
                    @for($i=1; $i<=$bills->lastPage();$i++)
                        <li><a  href="{{url('returnbilllist')}}/{{$paginationVal}}?page={{$i}}">{{$i}}</a></li>
                    @endfor
                </ul>
            </div>
        </div>
  </div>
<div class="table-responsive">
    <table  class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>رقم الفاتورة</th>
        <th>تاريخ الفاتورة</th>
		<th>رقم فاتورة المبيعات</th>
		<th>أنشئ بواسطة</th>
		<th>اجمالي المبلغ</th>
		<th>مبلغ الارجاع</th>

      </tr>
    </thead>
    <tbody>
    @foreach($bills as $bill)
      <tr>
        <td>{{$bill->id}}</td>
        <td>{{$bill->return_number}}</td>
        <td>{{$bill->return_date}}</td>
		<td>{{$bill->bill_id}}</td>
		<td>{{$bill->user['name_ar']}}</td>
		 <td>{{$bill->bill->total_final}}</td>
        <td>{{$bill->total_amount}}</td>

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
        </tr>
        </tfoot>
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

