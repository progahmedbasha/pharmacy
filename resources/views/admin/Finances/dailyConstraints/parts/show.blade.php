

@extends('layouts.admin')
@section('content')
    <style>
        .select2-search__field{
            width: 100%!important;
        }
    </style>
    <link href="{{asset('admin')}}/css/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="{{asset('admin/css/select2.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('admin/backEndFiles/sweetalert/sweetalert.css')}}">

    @include('layouts.loader.loaderCss')
    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{Session::get('success')}}
        </div>
    @endif
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">

        </div>
    </div>
    <div class="card">
        <div class="card-header">
            {{ trans('Finances.dailyConstraints') }}
        </div>
        <div class="card-body">

    <div class="row mt-2 mb-2 p-3 text-center">
        <button type="button" class="btn d-flex btn-light-success w-100 d-block text-info font-weight-medium">
            تفاصيل قيد يومى
        </button>
    </div>

    <div class="row">


        <div class="table-responsive-md col-sm-12">
            <table class="table  table-bordered" >
                <thead>
                <tr>
                    <th>رقم القيد</th>
                    <th>تاريخ القيد</th>
                    <th>البيان</th>
                    <th>اسم الحساب</th>
                    <th>بيان الحساب</th>
                    <th>المدين</th>
                    <th>الدائن</th>
                </tr>
                </thead>
                <tbody id="">
                @foreach($find->contain_details as $contain_details)
                <tr >
                    @if($loop->first)
                    <th rowspan="{{$find->contain_details->count()}}"><h3 style="margin-top: 50%!important;">{{$find->id}}</h3></th>
                    <th rowspan="{{$find->contain_details->count()}}"><h3 style="margin-top: 50%!important;">{{$find->date}}</h3></th>
                    <th rowspan="{{$find->contain_details->count()}}"><h3 style="margin-top: 50%!important;">{{$find->statement}}</h3></th>
                    @endif
                    <td>{{$contain_details->account_rl->name}}</td>
                    <td>{{$contain_details->statement}}</td>
                    <td>{{$contain_details->debit_value}}</td>
                    <td>{{$contain_details->creditor_value}}</td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="5"><h4 style="text-align: center"> الإجمالى </h4></th>
                    <th>{{$find->value}}</th>
                    <th>{{$find->value}}</th>
                </tr>
                </tfoot>
            </table>

        </div>

    </div>
        </div>
        <!-- order table -->



        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

            <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
            <div class="modal-dialog  modal-fullscreen modal-dialog-centered" role="document">


                <div class="modal-content" style="overflow-y: scroll !important;">

                    <div class="modal-body" id="form-for-addOrDelete">

                    </div>
                    <div class="modal-footer text-center d-flex justify-content-center">
                        <button id="save"  form="Form"  type="submit" class="btn btn-success">حفظ </button>

                        <button type="button" class="btn btn-light-danger text-danger font-weight-medium waves-effect text-start" data-dismiss="modal">الغاء</button>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->


        </section>
@endsection
