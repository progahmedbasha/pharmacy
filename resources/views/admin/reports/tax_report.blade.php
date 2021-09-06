@extends('admin.layouts.header')

@section('content')

    <div class="analytics-sparkle-area">
        <div class="container-fluid">
            <br><br>

            <br>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">

                        <br>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">

                                    <div class="col-md-12">
                                        <form method="get" class="form-inline has-validation-callback" action="{{route('TaxReport')}}">

                                            من:<input name="date_from" type="date" required="" class="form-control" value="{{Request::get('date_from') ? Request::get('date_from') : ''}}">
                                            إلي: <input name="date_to" type="date" required="" class="form-control" value="{{Request::get('date_to') ? Request::get('date_to') : ''}}">

                                            <div class="radio">
                                                <label class="radio-inline">
                                                    <input type="radio" name="tax_type" id="" value="0"  required {{ !is_null(Request::get('tax_type')) && Request::get('tax_type') == 0    ? 'checked' : ''}}> إقرار ضريبي ملخص
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="tax_type" id="" value="1" {{Request::get('tax_type') && Request::get('tax_type') == 1 ? 'checked' : ''}}> إقرار ضريبي مفصل
                                                </label>
                                            </div>


                                            <button type="submit" class="btn btn-info">بحث</button>
                                        </form>
                                    </div>

                                </div>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="table-data">
                                        <thead>
                                        <tr>


                                            @if(Request::get('tax_type') == 1)
                                                <th>رقم الحركة</th>
                                                <th>نوع العملية</th>
                                                <th>التاريخ</th>
                                                <th>العميل</th>
                                                <th>إجمالى الفاتورة</th>
                                                <th>إجمالى الضريبة</th>
                                                <th>إجمالى بعد الضريبة</th>
                                            @else
                                                <th>البيان</th>
                                                <th>المبلغ </th>
                                            @endif

                                        </tr>
                                        </thead>
                                        <tbody id="myTable">

                                        {!!$rows!!}



                                        </tbody>
                                    </table>
                                </div>
                            </div>


                        </div>
                    </div>


                </div>
            </div>
        </div>


        <script type="text/javascript">

            $("#table-data").DataTable({
                buttons: [
                    {
                        extend:'copy',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible',
                            text:'الطباعة'
                        }
                    },{
                        extend:'print',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible',
                            text:'الطباعة'
                        }
                    }
                ],

                dom: 'Bfrtip',
                //order: false,
                //searching: false,
                pageLength : 20
            });

        </script>
@endsection


