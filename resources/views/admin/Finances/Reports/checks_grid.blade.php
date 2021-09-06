@extends('admin.layouts.layout')

@section('styles')
    <link href="{{asset('admin')}}/css/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="{{asset('admin/css/select2.css')}}" rel="stylesheet">
    @include('admin.layouts.loader.loaderCss')
@endsection

@section('page-title')
    {{$page_title}}
@endsection

@section('current-page-name')
    {{$page_title}}
@endsection

@section('page-links')
    <li class="breadcrumb-item active">
        <a href="{{route('financesIndex.index')}}">الماليات</a>
    </li>
    <li class="breadcrumb-item active">    {{$page_title}} </li>
@endsection

@section('content')

    <div id="messages"></div>
    <div id="notes"></div>
    <section class="brands-page my-5">

        <!-- basic table -->
        <div class="row">
            <div class="col-12 mb-2">
                @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      {{Session::get('success')}}
                    </div>
                @endif
            </div>
            <div class="col-12">
                <div class="card">

                    <div class="card-body">


                        <div class="table-responsive">
                            <table id="basicExample" class="table  table-bordered">

                                <thead>
                                <tr>

                                    <th>رقم الإذن </th>
                                    <th>من حساب</th>
                                    <th>إلى حساب</th>
                                    <th>المبلغ</th>
                                    <th>البيان</th>
                                    <th>الصورة</th>
                                    <th>وقت الإضافة</th>
                                    @if($show_actions === true)
                                        <th>التحكم</th>
                                    @endif

                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- order table -->





    </section>

@endsection

@section('js')
    <script src="{{asset('admin')}}/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('admin/js/select2.js')}}"></script>
    <script src="{{asset('admin/backEndFiles/repeater/jquery.repeater.min.js')}}"></script>

    <script>

        var messages = $('#messages').notify({
            type: 'messages',
            removeIcon: '<i class="icon-close"></i>'
        });

        $("#basicExample").DataTable({
            dom: 'Bfrtip',
            responsive: 1,
            "processing": true,
            "lengthChange": true,
            "serverSide": true,
            "ordering": true,
            "searching": true,
            'iDisplayLength': 20,
            "ajax": "{{$route_url}}",
            "columns": [
                {"data": "id",   orderable: true,searchable: true},
                {"data": "creditor_rl",   orderable: true,searchable: true},

                {"data": "debit_rl",   orderable: true,searchable: true},
                {"data": "value",   orderable: true,searchable: true},
                {"data": "statement",   orderable: true,searchable: true},
                {"data": "image",   orderable: true,searchable: true},
                {"data": "created_at", searchable: true}
                <?php if($show_actions === true){?>
                ,
                {"data": "actions", orderable: false, searchable: false}
                <?php }?>
            ],
            "language": {
                "sProcessing":   "{{trans('admin.sProcessing')}}",
                "sLengthMenu":   "{{trans('admin.sLengthMenu')}}",
                "sZeroRecords":  "{{trans('admin.sZeroRecords')}}",
                "sInfo":         "{{trans('admin.sInfo')}}",
                "sInfoEmpty":    "{{trans('admin.sInfoEmpty')}}",
                "sInfoFiltered": "{{trans('admin.sInfoFiltered')}}",
                "sInfoPostFix":  "",
                "sSearch":       "{{trans('admin.sSearch')}}:",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst":    "{{trans('admin.sFirst')}}",
                    "sPrevious": "{{trans('admin.sPrevious')}}",
                    "sNext":     "{{trans('admin.sNext')}}",
                    "sLast":     "{{trans('admin.sLast')}}"
                }
            },
            order: [
                [2, "desc"]
            ],
        })


        

    </script>
@endsection
