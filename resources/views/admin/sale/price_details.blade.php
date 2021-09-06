@extends('admin.layouts.header')

@section('content')



     <div class="analytics-sparkle-area">
        <div class="container-fluid">

            <br> <br> <br>
             <a href="{{url()->previous()}}" type="button" class="btn btn-info">رجوع</a>

            <br><br>
            <div class="panel panel-default">
                <div class="panel-heading">تفاصيل طلبية المبيعات</div>
                <div class="panel-body">

                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="email">رقم عرض السعر</label><br>
                                <input type="text" class="form-control" value="{{$details->pricelist_number}}" disabled>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="email">العميل</label><br>
                                <input type="text" class="form-control" value="{{$details->employee->name}}" disabled>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="email">التاريخ</label><br>
                                <input type="text" class="form-control" value="{{$details->date}}" disabled>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="email">تاريخ الإنتهاء</label><br>
                                <input type="text" class="form-control" value="{{$details->expire_date}}" disabled>
                                </select>
                            </div>
                        </div>



                    </div>


                    <div class="row">
                        <div class="col-sm-12">
                            <br><br>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped main" id="dynamicTable">
                                    <tr>
                                        <th style="width:300px;">اســـم المنتـــج</th>
                                        <th>السعر</th>
                                        <th>الكمية</th>
                                        <th>الخصم</th>


                                    </tr>
                                    @foreach($details->items as $item)
                                        <tr>
                                            <td>{{$item->item_details->name}}</td>
                                            <td>{{$item->price}}</td>
                                            <td>{{$item->qty}}</td>
                                            <td>{{$item->discount}}</td>

                                        </tr>
                                    @endforeach
                                </table>
                            </div>


                        </div>
                    </div>





                </div>
            </div>


        </div>



    </div>

    <script type="text/javascript">

    </script>
@endsection

