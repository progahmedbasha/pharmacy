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
                <div class="panel-heading"</div>
                <div class="panel-body">
                    <form action="{{route('closeReportToday')}}"  method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <div >
                                        <div class="form-check" style="display:inline-block;">
                                            <input class="form-check-input" type="radio" name="type" value="allUsers" id="flexRadioDefault1" {{isset($token) && $request->type == 'allUsers' ? 'checked':'checked'}}>
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                {{__('Finances.allUsers')}}
                                            </label>
                                        </div>
                                        <div class="form-check" style="display:inline-block;">
                                            <input class="form-check-input" value="oneUser" type="radio" name="type" id="flexRadioDefault2" {{isset($token) && $request->type == 'oneUser' ? 'checked':''}}>
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                {{__('Finances.oneUser')}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">{{ __('Finances.day') }}:</label>
                                    <input type="date" class="form-control" name="day" value="{{isset($token)? $request->day: date('Y-m-d')}}" required>
                                </div>
                            </div>
                            <div class="col-md-4" >
                                <div class="form-group">
                                    <label for="pwd">{{ __('Finances.user') }}:</label>
                                <select name="user" required class="form-control select2">
                                    @if(isset($token))
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}" {{$user->id == $request->user ?'selected':''}}>{{$user->name_ar}}</option>
                                        @endforeach
                                    @else
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}" {{$user->id == auth()->user()->id ?'selected':''}}>{{$user->name_ar}}</option>
                                        @endforeach
                                    @endif
                                </select>
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
                            <td>إجمالى المبيعات اليوم</td>
                            <td>{{round($sale,3)}}</td>
                            <td>إجمالى سندات القبض اليوم</td>
                            <td>{{round($receipt,3)}}</td>
                        </tr>
                        <tr>
                            <td>إجمالى مرتجعات البيع اليوم</td>
                            <td>{{round($saleBack,3)}}</td>
                            <td>إجمالى سندات الصرف اليوم</td>
                            <td>{{round($billsOfExchange,3)}}</td>
                        </tr>
                        <tr>
                            <td>إجمالى مرتجعات الشراء اليوم</td>
                            <td>{{round($purchasesBack,3)}}</td>
                            <td>إجمالى مدفوعات الموردين اليوم</td>
                            <td>{{round($purchases,3)}}</td>
                        </tr>
                        <tr>
                            <td>إجمالى الرصيد فى الخزنة الحالى :</td>
                            <td>{{round($BoxBalance,3)}}</td>
                            <td>إجمالى الرصيد فى البنك الحالى :</td>
                            <td>{{round($BankBalance,3)}}</td>
                        </tr>
                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                <center>
                    <button onclick='openmodle("{{url("loadClosePrint")}}?user={{$request->user}}&day={{$request->day}}&type={{$request->type}}")' style="margin-top: 10px" class="btn btn-info"><i class="fa fa-print"></i></button>
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


