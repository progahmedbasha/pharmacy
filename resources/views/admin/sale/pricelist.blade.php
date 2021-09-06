@extends('admin.layouts.header')

@section('content')
    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet">


        <div class="analytics-sparkle-area">
            <div class="container-fluid">
			<br>
			عروض الاسعار: <a href="{{route('price_list.create')}}" class="btn btn-success">إنشاء عرض جديد</a>
			<br><br>
			<div class="row">
			<div class="col-md-3">
			<b>اجمالي عدد العروض</b> <span style="color:green;font-size:16px;">{{$all_price_list_count}}</span>
			</div>
			<div class="col-md-3">
			<b>اجمالي مبلغ العروض</b> <span style="color:green;font-size:16px;">{{$all_price_list_total}}</span>
			</div>
			<div class="col-md-3">
			<b>اجمالي العروض الفعالة</b> <span style="color:green;font-size:16px;">{{$active_price_list_count}}</span>
			</div>
			<div class="col-md-3">
			<b>اجمالي العروض المنتهية</b> <span style="color:green;font-size:16px;">{{$expired_price_list_count}}</span>
			</div>
			</div>
                <br>
                    <div class="panel panel-default">
                      <div class="panel-body">
                    <div class="table-responsive">
                    <table id="test" class="table">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>رقم الفاتورة</th>
                            <th>تاريخ الانشاء</th>
                            <th>تاريخ الانتهاء</th>
                            <th>أنشئ بواسطة</th>
                            <th>اجمالي المبلغ</th>
                            <th>موجه الي</th>

                            <th>الاجراءات</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($all_data as $row)
                              <tr>
                                <td>{{$row->id}}</td>
                                <td>{{$row->pricelist_number}}</td>
                                <td>{{$row->date}}</td>
                                <td>{{$row->expire_date}}</td>
                                  @if($row->employee)
                                  <td>{{$row->creator->name}}</td>
                                  @endif
                                  <td>{{$row->total}}</td>
                                  @if($row->employee)
                                <td>{{$row->employee->name ?? ''}}</td>
                                  @endif
                                <td>
                                    <a href="{{route('price_list.details', $row->id)}}" class="btn btn-info" title="عرض التفاصيل">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>

                                    <a href="{{route('price_list.convert_to_sale_bill', $row->id)}}" class="btn btn-danger" title="تحويل الى فاتورة مبيعات">
                                        <i class="fa fa-reply-all" aria-hidden="true"></i></a>
                                </td>
                              </tr>
                          @endforeach
                        </tbody>
                      </table>
                    {{--  {{$all_data->links()}}--}}
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

