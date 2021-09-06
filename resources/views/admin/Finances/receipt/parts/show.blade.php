




@extends('admin.layouts.header')
@section('content')
    <section style="padding: 10px">
    <style>
        .select2-search__field{
            width: 100%!important;
        }
        label{
            color: black;
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
    <div class="card">
        <div class="card-header">
            {{ trans('Finances.receipt') }}
        </div>
        <div class="card-body">

@csrf



    <div class="row">

        <div class="col-lg-3 col-md-6  mb-3">
            <label class="label mb-2 " for="name">التاريخ</label>
            <input type="date"  name="date" value="{{$find->date}}" disabled class="form-control" data-validation="required">
        </div>
        <input type="hidden" name="type" value="normal_snd_alsirf">

        <div class="col-lg-3 col-md-6  mb-3">
            <label class="label mb-2 " for="debit">من حساب</label>
            <select class="  form-control" disabled id="debit"  name="creditor_id" data-validation="required">
                <option value="" disabled selected> الحساب </option>

                @foreach($madins as $madin)
                    <option value="{{$madin->id}}" {{$madin->id == $find->creditor_id?'selected':''}} > {{$madin->name_ar}} </option>
                @endforeach

            </select>
        </div>
        <div class="col-lg-3 col-md-6  mb-3">
            <label class="label mb-2 " for="value">المبلغ</label>
            <input name="value" disabled value="{{$find->value}}" type="text" data-validation="required" class="form-control numbersOnly">
        </div>
        <div class="col-lg-3 col-md-6  mb-3">
            <label class="label mb-2 " for="value">البيان</label>
            <textarea name="statement" rows="3" disabled class="form-control" style="height: auto!important;">{{$find->statement}}</textarea>
        </div>




        <div class="col-lg-4 col-sm-6 mb-4">
            <label class="label mb-2 "> الصورة </label>
            <input type="file" class="dropify" disabled name="image" data-default-file="{{get_file($find->image)}}"/>
        </div>

        <div class="col-lg-3 col-md-6  mb-3">
            <label class="label mb-2 " for="PayType">طريقة الدفع</label>
            <select id="PayType" name="Pay" class="form-control " disabled data-validation="required">
                <option value="" selected disabled>الطريقة</option>
                <option value="" selected>{{$find->payment_type}}</option>

            </select>
        </div>





    </div>

            <div class="row" id="check" style="display: {{$find->payment_type == 'check'?'':'none'}}">

        <div class="col-lg-3 col-md-6  mb-3">
            <label class="label mb-2 " for="creditor">البنك</label>
            <select id="creditor" name="creditor_id" disabled class="form-control " data-validation="required">
                <option value="" selected disabled>البنك</option>
                @foreach($bank_accounts as $bank_account)
                    <option value="{{$bank_account->id}}" {{$find->debit_id == $bank_account->id ?'selected':''}}>{{$bank_account->name_ar}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-lg-3 col-md-6  mb-3">
            <label class="label mb-2 " for="">رقم الشيك</label>
            <input type="text" name="check_number" value="{{$find->check_number}}" disabled data-validation="required" class="form-control numbersOnly">
        </div>


        <div class="col-lg-3 col-md-6  mb-3">
            <label class="label mb-2 " for="">تاريخ الشيك</label>
            <input type="date" name="check_date" disabled value="{{$find->check_date}}" data-validation="required" class="form-control">
        </div>


    </div>


            <div class="row" id="money" style="display: {{$find->payment_type == 'cash'?'':'none'}}">

        <div class="col-lg-3 col-md-6  mb-3">
            <label class="label mb-2 " for="creditor2">الخزنة</label>
            <select id="creditor2"  disabled class="form-control " data-validation="required">
                <option value="" selected >الخزنة</option>
                @foreach($box_accounts as $box_account)
                    <option value="{{$box_account->id}}" {{$find->debit_id == $box_account->id ?'selected':''}}>{{$box_account->name_ar}}</option>
                @endforeach
            </select>
        </div>

    </div>


        </div>
    </div>
    <!-- order table -->



    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

        <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
        <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">


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
    <div class="modal fade" id="exampleModalCenter2" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

        <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
        <div class="modal-dialog  modal-fullscreen modal-dialog-centered" role="document">


            <div class="modal-content" style="overflow-y: scroll !important;">

                <div class="modal-body" id="form-for-addOrDelete2">

                </div>
                <div class="modal-footer text-center d-flex justify-content-center">

                    <button type="button" class="btn btn-light-danger text-danger font-weight-medium waves-effect text-start" data-dismiss="modal">الغاء</button>

                </div>
            </div>
        </div>
    </div>


    </section>
@endsection
@section('scripts')

    <script>
        $(document).on('change', '#PayType', function () {

            if ($(this).val() == 'cash'){
                $('#money').show()
                $('#check').hide()
            }else if($(this).val() == 'check'){
                $('#money').hide()
                $('#check').show()
            }else {
                $('#money').hide()
                $('#check').hide()
            }

        });
    </script>

@endsection
