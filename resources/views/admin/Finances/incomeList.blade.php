@extends('admin.layouts.header')

@section('content')
    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet">


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

                                    <div class="col-md-6">
                                        <form method="get" class="form-inline has-validation-callback" action="{{route('IncomeList')}}">

                                            من:<input name="date_from" type="date" required="" class="form-control">
                                            إلي: <input name="date_to" type="date" required="" class="form-control">
                                            <button type="submit" class="btn btn-info">بحث</button>
                                        </form>
                                    </div>

                                </div>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="test">
                                        <thead>
                                        <tr>
                                            <th>البيان</th>
                                            <th>المبلغ </th>

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

        <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>

        <script type="text/javascript">

            $("#test").DataTable({
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
                order: false,
                searching: false
            });

        </script>
@endsection


