@extends('admin.layouts.header')
@section('content')
    <section style="padding: 10px">
    <style>
        .select2-search__field{
            width: 100%!important;
        }
    </style>
    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet">
    {{--    <link rel="stylesheet" href="{{asset('admin/backEndFiles/sweetalert/sweetalert.css')}}">--}}
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
            <a href="{{route('receipt.create')}}" id="" class="btn mb-2 btn-success "> أضف <span class="icon-add_circle"></span>  </a>

        </div>
    </div>
    <div class="card">
        <div class="card-header">
            {{ trans('Finances.receipt') }}
        </div>
        <div class="card-body">


            <div class="table-responsive">
                <table  id="test" class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-ShippingAndClearance" >

                    <thead>
                    <tr>
                        <th width="10px" class="not-exported">

                        </th>
                        <th>م</th>
                        <th>من حساب</th>
                        <th>إلى حساب</th>
                        <th>المبلغ</th>
                        <th>طريقة الدفع</th>
                        <th>البيان</th>
                        <th>الصورة</th>
                        <th  class="not-exported">التحكم</th>

                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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



    <script src="{{asset('admin/backEndFiles/sweetalert/sweetalert.min.js')}}"></script>

    <script>


        $("#test").DataTable({
            buttons: [
              
            ],
         
            dom: 'Bfrtip',
            responsive: 1,
            "processing": true,
            "lengthChange": true,
            "serverSide": true,
            "ordering": true,
            "searching": true,
            'iDisplayLength': 20,
            "ajax": "{{route('receipt.index')}}",
            "columns": [
                {"data": "placeholder",   orderable: true,searchable: true},
                {"data": "id",   orderable: true,searchable: true},
                {"data": "creditor_rl",   orderable: true,searchable: true},
                {"data": "debit_rl",   orderable: true,searchable: true},
                {"data": "value",   orderable: true,searchable: true},
                {"data": "payment_type",   orderable: true,searchable: true},
                {"data": "statement",   orderable: true,searchable: true},
                {"data": "image",   orderable: true,searchable: true},
                {"data": "actions", orderable: false, searchable: false}
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
                [1, "desc"]
            ],
        })






        //========================================================================
        //========================================================================
        //=======================Add , edit model=================================
        //========================================================================
        $(document).on('click','#addButton',function (e) {
            e.preventDefault()
            var url = '{{route('receipt.create')}}';
            $.ajax({
                url: url,
                type: 'GET',
                beforeSend: function(){
                    $('select').each(function () {
                        $(this).select2({ dropdownParent: $(this).parent() });
                    });

                    $('.loader-ajax').show()
                },
                success: function(data){
                    window.setTimeout(function() {
                        $('.loader-ajax').hide()

                        $('#form-for-addOrDelete').html(data.html);
                        $('#exampleModalCenter').show()
                        $('.dropify').dropify();

                        $('select').select2();
                        $.validate({
                        });
                    }, 2000);
                },
                error: function(jqXHR,error, errorThrown) {
                    $('.loader-ajax').Form.hide()
                    if(jqXHR.status&&jqXHR.status==500){
                        $('#exampleModalCenter').modal("hide");
                        $('#form-for-addOrDelete').html('<h3 class="text-center">لا تملك الصلاحية</h3>')
                        //save
                        messages.show("لا تملك هذه الصلاحية..", {
                            type: 'danger',
                            title: '',
                            icon: '<i class="icon-error"></i>',
                            delay:2000,
                        });
                    }


                }
            });
        });

        $(document).on('click','.editButton',function (e) {
            e.preventDefault()
            var id = $(this).attr('id');

            var url = '{{route('receipt.edit',":id")}}';
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: 'GET',
                beforeSend: function(){

                    $('.loader-ajax').show()
                },
                success: function(data){
                    window.setTimeout(function() {

                        $('#form-for-addOrDelete').html(data.html);
                        $('.loader-ajax').hide()
                        $('#exampleModalCenter').modal('show')
                        $('.dropify').dropify();
                        $('.linear-background').hide()

                        $('select').select2();

                        $.validate({
                        });
                    }, 2000);
                },
                error: function(data) {
                    $('.loader-ajax').hide()
                    $('#form-for-addOrDelete').html('<h3 class="text-center">لا تملك الصلاحية</h3>')
                    messages.show("لا تملك هذه الصلاحية..", {
                        type: 'danger',
                        title: '',
                        icon: '<i class="icon-error"></i>',
                        delay:2000,
                    });
                }
            });

        });

        $(document).on('click','.showButton',function (e) {
            e.preventDefault()
            var id = $(this).attr('id');

            var url = '{{route('receipt.show',":id")}}';
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: 'GET',
                beforeSend: function(){
                    $('select').each(function () {
                        $(this).select2({ dropdownParent: $(this).parent() });
                    });


                    $('.loader-ajax').show()
                },
                success: function(data){
                    window.setTimeout(function() {
                        $('#form-for-addOrDelete2').html(data.html);
                        $('.loader-ajax').hide()
                        $('#exampleModalCenter2').modal('show')
                        $('.dropify').dropify();
                        $('.linear-background').hide()

                        $.validate({
                        });
                    }, 2000);
                },
                error: function(data) {
                    $('.loader-ajax').hide()
                    $('#form-for-addOrDelete').html('<h3 class="text-center">لا تملك الصلاحية</h3>')
                    messages.show("لا تملك هذه الصلاحية..", {
                        type: 'danger',
                        title: '',
                        icon: '<i class="icon-error"></i>',
                        delay:2000,
                    });
                }
            });

        });

        //=========================================================
        //=========================================================
        //========================Save Data=========================
        //=========================================================

        $(document).on('submit','form#Form',function(e) {
            e.preventDefault();
            var myForm = $("#Form")[0]
            var formData = new FormData(myForm)
            var url = $('#Form').attr('action');
            $.ajax({
                url:url,
                type: 'POST',
                data: formData,
                beforeSend: function(){
                    $('.loader-ajax').show()

                },
                complete: function(){


                },
                success: function (data) {

                    window.setTimeout(function() {
                        $('.loader-ajax').hide()
                        $('#exampleModalCenter').modal('hide')
                        messages.show("تمت العملية بنجاح..", {
                            type: 'success',
                            title: '',
                            icon: '<i class="jq-icon-success"></i>',
                            delay:2000,
                        });
                        $('#basicExample').DataTable().ajax.reload();

                    }, 2000);


                },
                error: function (data) {
                    $('.loader-ajax').hide()
                    if (data.status === 500) {
                        // $('#exampleModalCenter').modal("hide");
                        messages.show("هناك خطأ", {
                            type: 'danger',
                            title: 'خطأ',
                            icon: '<i class="icon-alert-octagon"></i>',
                            delay:2000,
                        });
                    }
                    if (data.status === 422) {
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors, function (key, value) {
                            if ($.isPlainObject(value)) {
                                $.each(value, function (key, value) {
                                    myToast(key, value, 'top-left', '#ff6849', 'error',4000, 2);

                                });

                            } else {

                            }
                        });
                    }
                },//end error method

                cache: false,
                contentType: false,
                processData: false
            });
        });
        //========================================================================
        //========================================================================
        //============================Delete======================================
        //========================================================================
        //delete one row
        $(document).on('click', '.delete', function () {
            var id = $(this).attr('id');
            swal({
                title: "هل أنت متأكد من الحذف؟",
                text: "لا يمكنك التراجع بعد ذلك؟",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "موافق",
                cancelButtonText: "الغاء",
                okButtonText: "موافق",
                closeOnConfirm: false
            }, function () {
                var url = '{{ route("receipt.destroy", ":id") }}';
                url = url.replace(':id', id);
                console.log(url);
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {id: id},
                    success: function (data) {
                        swal.close()
                        myToast('بنجاح', 'تم الأمر بنجاح', 'top-left', '#ff6849', 'success',4000, 2);
                        messages.show("تمت العملية بنجاح..", {
                            type: 'success',
                            title: '',
                            icon: '<i class="jq-icon-success"></i>',
                            delay:2000,
                        });
                        $('#basicExample').DataTable().ajax.reload();
                    },error: function(data) {
                        swal.close()
                        messages.show("لا تملك الصلاحية للحذف", {
                            type: 'danger',
                            title: '',
                            icon: '<i class="icon-error"></i>',
                            delay:2000,
                        });
                    }

                });
            });
        });

        $(document).on('change', '#PayType', function () {

            if ($(this).val() == 'money'){
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
