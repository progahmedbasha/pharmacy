


@extends('admin.layouts.header')
@section('content')
    <section style="padding: 10px">
    <style>
        .select2-search__field{
            width: 100%!important;
        }
        label{
            color: black!important;
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
            {{ trans('Finances.billsOfExchange') }}
        </div>
        <div class="card-body">

    <form action="{{route('billsOfExchange.update',$find->id)}}" method="post" id="Form" enctype="multipart/form-data">
    @csrf
    @method('PUT')


    <div class="row">

        <div class="col-lg-3 col-md-6  mb-3">
            <label class="label mb-2 " for="name">التاريخ</label>
            <input type="date"  name="date" value="{{$find->date}}"  class="form-control" data-validation="required">
        </div>
        <input type="hidden" name="type" value="normal_snd_alsirf">

        <div class="col-lg-3 col-md-6  mb-3">
            <label class="label mb-2 " for="debit">إلى حساب</label>
            <select class="  form-control"  id="debit"  name="debit_id" data-validation="required">
                <option value="" disabled selected> الحساب </option>

                @foreach($madins as $madin)
                    <option value="{{$madin->id}}" {{$madin->id == $find->debit_id?'selected':''}} > {{$madin->name_ar}} </option>
                @endforeach

            </select>
        </div>
        <div class="col-lg-3 col-md-6  mb-3">
            <label class="label mb-2 " for="value">المبلغ</label>
            <input name="value"  value="{{$find->value}}" type="text" data-validation="required" class="form-control numbersOnly">
        </div>
        <div class="col-lg-3 col-md-6  mb-3">
            <label class="label mb-2 " for="value">البيان</label>
            <textarea name="statement" rows="3"  class="form-control" style="height: auto!important;">{{$find->statement}}</textarea>
        </div>




        <div class="col-lg-4 col-sm-6 mb-4">
            <label class="label mb-2 "> الصورة </label>
            <input type="file" class="dropify"  name="image" data-default-file="{{get_file($find->image)}}"/>
        </div>

        <div class="col-lg-3 col-md-6  mb-3">
            <label class="label mb-2 " for="PayType">طريقة الدفع</label>
            <select id="PayType" name="payment_type" class="form-control " required data-validation="required">
                <option value="" selected disabled>الطريقة</option>
                <option value="cash" {{$find->payment_type == 'cash'?'selected':''}} >نقدي</option>
                <option value="check" {{$find->payment_type == 'check'?'selected':''}}>شيك</option>
            </select>
        </div>





    </div>

        <div class="row" id="check" style="display: {{$find->payment_type == 'check'?'':'none'}}">

        <div class="col-lg-3 col-md-6  mb-3">
            <label class="label mb-2 " for="creditor">البنك</label>
            <select id="creditor" name="check_id"  class="form-control " data-validation="required">
                <option value="" selected >البنك</option>
                @foreach($bank_accounts as $bank_account)
                    <option value="{{$bank_account->id}}" {{$find->creditor_id == $bank_account->id ?'selected':''}}>{{$bank_account->name_ar}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-lg-3 col-md-6  mb-3">
            <label class="label mb-2 " for="">رقم الشيك</label>
            <input type="text" name="check_number"  value="{{$find->check_number}}" data-validation="required" class="form-control numbersOnly">
        </div>


        <div class="col-lg-3 col-md-6  mb-3">
            <label class="label mb-2 " for="">تاريخ الشيك</label>
            <input type="date" name="check_date"  value="{{$find->check_date}}" data-validation="required" class="form-control">
        </div>


    </div>


    <div class="row" id="money" style="display:  {{$find->payment_type == 'cash'?'':'none'}}">

        <div class="col-lg-3 col-md-6  mb-3">
            <label class="label mb-2 " for="creditor2">الخزنة</label>
            <select id="creditor2" name="money_id"  class="form-control " data-validation="required">
                <option value="" selected >الخزنة</option>
                @foreach($box_accounts as $box_account)
                    <option value="{{$box_account->id}}" {{$find->creditor_id == $box_account->id ?'selected':''}}>{{$box_account->name_ar}}</option>
                @endforeach
            </select>
        </div>

    </div>


        <button id="save"   type="submit" class="btn btn-success">حفظ </button>

    </form>

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
