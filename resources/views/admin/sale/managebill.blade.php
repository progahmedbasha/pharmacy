@extends('admin.layouts.header')

@section('content')
    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet">

        <div class="analytics-sparkle-area">
            <div class="container-fluid">
<br>
			إدارة الفواتير: <a href="{{url('addsalesbill')}}" class="btn btn-success">إنشاء فاتورة</a>
			<br><br>

      <iframe id="iframe" src="" style="display:none;"></iframe>

			<div class="row">
                <div class="col-md-2">
                    <b>اجمالي عدد الفواتير</b> <span style="color:green;font-size:16px;">{{count($bills)}}</span>
                </div>
                <div class="col-md-2">
                    <b>اجمالي المبيعات</b> <span style="color:green;font-size:16px;">{{round($total_final,2)}}</span>
                </div>
                <div class="col-md-2">
                    <b>اجمالي المدفوع</b> <span style="color:green;font-size:16px;">{{round($paid_amount,2)}}</span>
                </div>
                <div class="col-md-2">
                    <b>اجمالي المتبقي</b> <span style="color:green;font-size:16px;">{{round($remaining_amount,2)}}</span>
                </div>
                <div class="col-md-2">
                    <b>اجمالي المرتجعات</b> <span style="color:green;font-size:16px;">{{round($total_returns,2)}}</span>
                </div>
			</div>
<br>



<div class="panel panel-default">
  <div class="panel-body">

  	<div class="row">
  	<div class="col-md-6">
      <form method="get" class="form-inline" action="{{url('managebill')}}/{{$paginationVal}}">
          <input class="form-control input-lg" name="search_val" type="text" >
          <select class="form-control" name="is_paid">
              <option value="">----كل الفواتير----</option>
              <option value="1" @if(Request::get('payment_type') == 1) selected @endif>مسددة بالكامل</option>
              <option value="2" @if(Request::get('payment_type') == 2) selected @endif> لم تسدد </option>
              <option value="3" @if(Request::get('payment_type') == 3) selected @endif> مسدد جزء </option>
          </select>

          <select class="form-control" name="user_id">
              <option value="">أنشئ بواسطة</option>
              @foreach($users as $user)
              <option value="{{$user->id}}" @if(Request::get('user_id') == $user->id) selected @endif> {{$user->name}} </option>
              @endforeach
          </select>

          <select class="form-control" name="cus_id">
              <option value="">إسم العميل </option>
               @foreach($customers as $customer)
              <option value="{{$customer->id}}" @if(Request::get('cus_id') == $customer->id) selected @endif> {{$customer->name}} </option>
              @endforeach
          </select>

          <label>من <input class="form-control input"  name="date_from" type="date" ></label>

            <label> إلي:<input class="form-control input"  name="date_to" type="date" ></label>
           

          <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i></button>
          <a href="{{url('managebill')}}/{{$paginationVal}}" class="btn btn-danger" style="margin-top:0px;"><i class="fa fa-times"></i></a>
      </form>
</div>

<button class="btn btn-primary dropdown-toggle"  type="button" ><a href="{{ route('salebill.export') }}" >Export</a></button>

        <div class="col-md-3">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">عدد الصفوف : {{$paginationVal}}
                    <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a  href="{{url('managebill')}}/10">10</a></li>
                    <li><a  href="{{url('managebill')}}/25">25</a></li>
                    <li><a  href="{{url('managebill')}}/50">50</a></li>
                    <li><a  href="{{url('managebill')}}/100">100</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-2">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">رقم الصفحة : {{$bills->currentPage()}}
                    <span class="caret"></span></button>
                <ul class="dropdown-menu" style="overflow-y: scroll;height:200px;">
                    @for($i=1; $i<=$bills->lastPage();$i++)
                        <li><a  href="{{url('managebill')}}/{{$paginationVal}}?page={{$i}}">{{$i}}</a></li>
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
        <th>رقم الفاتورة</th>
        <th>تاريخ الفاتورة</th>
		<th>أنشئ بواسطة</th>
        <th>إسم العميل</th>
		<th>اجمالي المبلغ</th>
		<th>المدفوع</th>
		<th>المتبقي</th>
		<th>الحالة</th>
		<th>الاجراءات</th>
      </tr>
    </thead>
    <tbody>
     @foreach($bills as $index=>$value)
      <tr>
        <td>{{$index+1}}</td>
        <td>{{$value->bill_number}}</td>
        <td>{{$value->bill_date}}</td>
		<td>{{$value->user->name}}</td>
        <td>{{$value->customer->name}}</td>
		<td>{{$value->total_final}}</td>
        <td>{{round($value->paid_amount,2)}}</td>
        <td>{{$value->remaining_amount}}</td>
        @if($value->is_paid == 1)
			<td>مكتمل</td>
		@elseif(0)
			<td>غير مكتمل</td>
          @elseif(2)
            <td>مرتجع</td>
		@endif


          @if($value->is_paid == 1  or $value->is_paid == 0)
              <td>
                  <a href="{{url('salebilldetail')}}/{{$value->id}}" class="btn btn-info">
                      <i class="fa fa-eye" aria-hidden="true"></i></a>

                  <button type="button" class="btn btn-success"  style="margin-top: 15px;" onclick='openmodle("{{url('printsalebill')}}/{{ $value->id }}")'>
                      <i class="fa fa-print" aria-hidden="true"></i></button>

                  <a href="{{url('returnbillaction')}}/{{$value->id}}" class="btn btn-danger">
                      <i class="fa fa-reply-all" aria-hidden="true"></i></a>


              </td>
          @elseif($value->is_paid == 2)
              <td> <a href="{{url('salebilldetail')}}/{{$value->id}}" class="btn btn-info">
                      <i class="fa fa-eye" aria-hidden="true"></i></a>

                  <button type="button" class="btn btn-success"  style="margin-top: 15px;" onclick='openmodle("{{url('printsalebill')}}/{{ $value->id }}")'>
                      <i class="fa fa-print" aria-hidden="true"></i></button>


              </td>
          @endif



      </tr>
      @endforeach
    </tbody>
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



  // $("#test").DataTable({
  //     buttons: [
  //         {
             
  //             customize: function(win) {
  //                 $(win.document.body).prepend('<div class="row"><div class="col-md-3"><b>اجمالي عدد الفواتير</b> <span style="color:green;font-size:16px;">{{count($bills)}}</span></div><div class="col-md-3"><b>اجمالي المبيعات</b> <span style="color:green;font-size:16px;">{{round($total_final,2)}}</span></div><div class="col-md-3"><b>اجمالي المدفوع</b> <span style="color:green;font-size:16px;">{{round($paid_amount,2)}}</span></div><div class="col-md-3"><b>اجمالي المتبقي</b> <span style="color:green;font-size:16px;">{{round($remaining_amount,2)}}</span></div></div>');
  //             }
  //         }/*
  //         }*/,{
              
  //         }/
  //     ],
  //     initComplete: function () {
  //         this.api().columns([0,1,2,3,4,5,6,7]).every(function () {
  //             var column = this;
  //             var search = $(`<input style="font-size: 85%;height: 15px;width: 100%" class="form-control form-control-sm" type="text" placeholder="بحث .... ">`)
  //                 .appendTo($(column.footer()).empty())
  //                 .on('change input', function () {
  //                     var val = $(this).val()

  //                     column
  //                         .search(val ? val : '', true, false)
  //                         .draw();
  //                 });
  //         });
  //     },
  //     dom: 'Bfrtip',
  //     order: [
  //         [2, "desc"]
  //     ],
  // });
</script>


    @endsection

