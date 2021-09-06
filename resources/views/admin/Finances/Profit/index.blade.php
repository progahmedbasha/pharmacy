@extends('admin.layouts.header')

@section('content')
    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet">

    <style>
        #com_info{
            display:none;
        }
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>


    <div class="analytics-sparkle-area">
        <iframe id="iframe" src="" style="display:none;"></iframe>
        <div class="container-fluid">
            <br>

            <div class="panel panel-default">
                <div class="panel-heading"></div>
                <div class="panel-body">
                    <form action="{{route('Profit')}}"  method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">{{ __('Finances.from') }}:</label>
                                    <input type="date" class="form-control" name="from" value="{{isset($token)? $request->from: date('Y-m-d',strtotime(date('Y-m-d'). '- 30 days'))}}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">{{ __('Finances.to') }}:</label>
                                    <input type="date" class="form-control" name="to" value="{{isset($token)? $request->to: date('Y-m-d')}}" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">{{ __('Finances.search') }}</button>
                            </div>

                    </form>


                </div>
                @if(isset($token))
                    <table>
                        <tbody>
                        <tr>
                            <td>إجمالى المبيعات فى هذه الفترة</td>
                            <td>{{round($sale,3)}}</td>
                            <td>إجمالى المصروفات فى هذه الفترة</td>
                            <td>{{round($expenses,3)}}</td>
                        </tr>
                        <tr>
                            <td>إجمالى مرتجعات البيع فى هذه الفترة</td>
                            <td>{{round($saleBack,3)}}</td>
                            <td>إجمالى خصومات المبيعات فى هذه الفترة</td>
                            <td>{{round($discount,3)}}</td>
                        </tr>
                        <tr>

                            <td style="color: blue">إجمالى الأرباح فى هذه الفترة</td>
                            <td>{{round($total,3)}}</td>
                        </tr>

                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                <center>
                    <button onclick='openmodle("{{url("profitPrint")}}?from={{$request->from}}&to={{$request->to}}")' style="margin-top: 10px" class="btn btn-info"><i class="fa fa-print"></i></button>
                </center>
                @endif
            </div>

        </div>
    </div>

    <script>

        function openmodle(url){
            document.getElementById("iframe").src=url;
        }

        function company_info_disable(){
            document.getElementById("com_info").style.display = "none";
        }

        function company_info_enable(){
            document.getElementById("com_info").style.display = "block";
        }
    </script>
@endsection


