
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
    <form action="{{route('admin.dailyConstraints.store')}}" method="post" id="Form">
        @csrf

        <div class="FindSelect">
            <div class="row mt-2 mb-2 p-3 text-center">
                <button type="button" class="btn d-flex btn-light-success w-100 d-block text-info font-weight-medium">
                    إضافة قيد يومى جديد
                </button>
            </div>

            <div class="row">


                <div class="col-lg-4 col-md-6  mb-4">
                    <label class="label mb-2 " for="name">رقم القيد</label>
                    <input type="text"  disabled value="{{$last_id}}" class="form-control" data-validation="required">
                </div>
                <div class="col-lg-4 col-md-6  mb-4">
                    <label class="label mb-2 " for="name">التاريخ</label>
                    <input type="date"  name="date" value="{{date('Y-m-d')}}" class="form-control" data-validation="required">
                </div>
                <div class="col-lg-4 col-md-6  mb-4">
                    <label class="label mb-2 " for="name">البيان</label>
                    <textarea  name="main_statement" rows="3" style="height: auto!important;" class="form-control" ></textarea>
                </div>
                <input type="hidden" name="type" value="daily_constrain">
                <div class="table-responsive-md col-sm-12">
                    <table class="table table-striped-table-bordered table-hover table-checkable table-" id="tbl_posts">
                        <thead>
                        <tr>

                            <th>   مدين   <a class="btn btn-info add-record-madeen click" data-added="0" style="float: left!important;"><i class="fa fa-plus"></i></a> </th>
                            <th>   دائن   <a class="btn btn-info add-record-dayyen click" data-added="0" style="float: left!important;"><i class="fa fa-plus"></i></a> </th>
                            <th >إسم الحساب</th>
                            <th >بيان الحساب</th>
                            <th ></th>
                        </tr>
                        </thead>
                        <tbody id="tbl_posts_body">
                        <tr id="rec-madeen-1" class="madeen">
                            <td>
                                <input type="text" value="0" name="debit_value[]" data-validation="required" class="form-control numbersOnly change-elumnt debit_value"  placeholder=" قيمة المدين..." >
                            </td>
                            <td>
                                ----
                            </td>
                            <td>
                                <select name="account_id_madeen[]" class="form-control newSelect" data-validation="required">
                                    <option value="">إختر الحساب</option>
                                    @foreach($accounts as $account)
                                        <option value="{{$account->id}}">{{$account->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <textarea class="form-control" name="statement_madeen[]" style="height: auto;"></textarea>
                            </td>
                            <td><a class="btn btn-xs delete-record-madeen " data-id="1"><i style="color: #f4516c" class="fa fa-trash"></i></a></td>
                        </tr>
                        <tr id="rec-dayyen-1" class="dayyen">
                            <td>
                                ----
                            </td>
                            <td>
                                <input type="text" value="0" name="creditor_value[]" data-validation="required" class="form-control numbersOnly creditor_value change-elumnt"  placeholder=" قيمة الدائن..." >
                            </td>
                            <td>
                                <select name="account_id_dayyen[]" class="form-control newSelect" data-validation="required">
                                    <option value="">إختر الحساب</option>
                                    @foreach($accounts as $account)
                                        <option value="{{$account->id}}">{{$account->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <textarea class="form-control" name="statement_dayyen[]" style="height: auto;"></textarea>
                            </td>
                            <td><a class="btn btn-xs delete-record-dayyen " data-id="1"><i style="color: #f4516c" class="fa fa-trash"></i></a></td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td><input class="form-control numbersOnly" name="totalval" readonly id="debit_value" value="0"></td>
                            <td><input class="form-control numbersOnly" readonly id="creditor_value" value="0"></td>
                            <td colspan="3"><h3 style="text-align: center!important;">الإجمالى</h3></td>
                        </tr>
                        </tfoot>
                    </table>

                </div>




            </div>
        </div>
        <button id="save"  form="Form"  type="submit" class="btn btn-success">حفظ </button>

    </form>
    <div style="display:none;">
        <table id="sample_table-dayyen">
            <tr id="" class="dayyen">
                <td>
                    ----
                </td>
                <td>
                    <input type="text" value="0" name="creditor_value[]" data-validation="required" class="form-control numbersOnly creditor_value change-elumnt"  placeholder=" قيمة الدائن..." >
                </td>
                <td>
                    <select name="account_id_dayyen[]" class="form-control" data-validation="required">
                        <option value="">إختر الحساب</option>
                        @foreach($accounts as $account)
                            <option value="{{$account->id}}">{{$account->name}}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <textarea class="form-control" name="statement_dayyen[]" style="height: auto;"></textarea>
                </td>
                <td><a class="btn btn-xs delete-record-dayyen " data-id="1"><i style="color: #f4516c" class="fa fa-trash"></i></a></td>
            </tr>
        </table>

        <table id="sample_table-madeen">
            <tr id="" class="madeen">
                <td>
                    <input type="text" value="0" name="debit_value[]" data-validation="required" class="form-control numbersOnly change-elumnt debit_value"  placeholder=" قيمة المدين..." >
                </td>
                <td>
                    ----
                </td>
                <td>
                    <select name="account_id_madeen[]" class="form-control" data-validation="required">
                        <option value="">إختر الحساب</option>
                        @foreach($accounts as $account)
                            <option value="{{$account->id}}">{{$account->name}}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <textarea class="form-control" name="statement_madeen[]" style="height: auto;"></textarea>
                </td>
                <td><a class="btn btn-xs delete-record-madeen " data-id="1"><i style="color: #f4516c" class="fa fa-trash"></i></a></td>
            </tr>
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
@section('scripts')

    <script src="{{asset('admin')}}/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('admin/js/select2.js')}}"></script>
    <script src="{{asset('admin/backEndFiles/repeater/jquery.repeater.min.js')}}"></script>
    <script src="{{asset('admin/backEndFiles/sweetalert/sweetalert.min.js')}}"></script>

    @parent
    <script>

        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        @can('shipping_and_clearance_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
        @endcan


        $("#test").DataTable({
            buttons:dtButtons,
            dom: 'Bfrtip',
            responsive: 1,
            "processing": true,
            "lengthChange": true,
            "serverSide": true,
            "ordering": true,
            "searching": true,
            'iDisplayLength': 20,
            "ajax": "{{route('admin.dailyConstraints.index')}}",
            "columns": [
                {"data": "placeholder", orderable: false, searchable: false},
                {"data": "id",   orderable: true,searchable: true},
                {"data": "value",   orderable: true,searchable: true},
                {"data": "date",   orderable: true,searchable: true},
                {"data": "created_at",   orderable: true,searchable: true},
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
            var url = '{{route('admin.dailyConstraints.create')}}';
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
                        $('#exampleModalCenter').modal('show')


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

            var url = '{{route('admin.dailyConstraints.edit',":id")}}';
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

            var url = '{{route('admin.dailyConstraints.show',":id")}}';
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: 'GET',
                beforeSend: function(){
                    // $('select').each(function () {
                    //     $(this).select2({ dropdownParent: $(this).parent() });
                    // });


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

            if (parseInt($('#creditor_value').val()) != parseInt($('#debit_value').val()) ){
                alert('القيمتين غير متساويتين')
            }else {
                if (parseInt($('#creditor_value').val()) == 0){
                    alert('القيمة تساوي 0 ')
                }else {
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
                                $('#basicExample').DataTable().ajax.reload();

                                $('.loader-ajax').hide()
                                window.location.href = "/admin/dailyConstraints"

                                $('#exampleModalCenter').modal('hide')
                                messages.show("تمت العملية بنجاح..", {
                                    type: 'success',
                                    title: '',
                                    icon: '<i class="jq-icon-success"></i>',
                                    delay:2000,
                                });

                            }, 2000);


                        },
                        error: function (data) {
                            $('.loader-ajax').hide()
                            if (data.status === 500) {
                                // $('#exampleModalCenter').modal("hide");
                                messages.show("ليس لك صلاحية ", {
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

                }
            }


        });
        //========================================================================
        //========================================================================
        //============================Delete======================================
        //========================================================================
        //delete one row
        $(document).on('click', '.', function () {
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
                var url = '{{ route("admin.dailyConstraints.destroy", ":id") }}';
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

    </script>



    {{------------------------- add-record-dayyen ---------------------}}
    <script>
        jQuery(document).delegate('a.add-record-dayyen', 'click', function(e) {



            e.preventDefault();
            var content = jQuery('#sample_table-dayyen tr'),
                size = jQuery('#tbl_posts >tbody >tr').length + 1,
                element = null,
                element = content.clone();
            element.attr('id', 'rec-dayyen-'+size);
            element.find('.delete-record-dayyen').attr('data-id', size);
            element.appendTo('#tbl_posts_body');

            // element.find('select').select2()


            var debit = 0;
            $('.debit_value').each(function(){

                debit += parseFloat(parseInt($(this).val()) || 0);  // Or this.innerHTML, this.innerText
            });

            $('#debit_value').val(debit)

            var creditor = 0;
            $('.creditor_value').each(function(){
                creditor += parseFloat(parseInt($(this).val()) || 0);  // Or this.innerHTML, this.innerText
            });

            $('#creditor_value').val(creditor)




        });
        /*************/
        jQuery(document).delegate('a.delete-record-dayyen', 'click', function(e) {




            var numdivs = $('.dayyen').length;

            if (numdivs == 2){
                alert('لا يمكن الحذف')
            }else {
                e.preventDefault();
                // var didConfirm = confirm("Are you sure You want to delete");
                // if (didConfirm == true) {
                var id = jQuery(this).attr('data-id');
                var targetDiv = jQuery(this).attr('targetDiv');
                jQuery('#rec-dayyen-' + id).remove();

                //regnerate index number on table
                $('#tbl_posts_body tr').each(function (index) {
                    //alert(index);
                    $(this).find('span.sn').html(index + 1);
                });



                var debit = 0;
                $('.debit_value').each(function(){

                    debit += parseFloat(parseInt($(this).val()) || 0);  // Or this.innerHTML, this.innerText
                });

                $('#debit_value').val(debit)

                var creditor = 0;
                $('.creditor_value').each(function(){
                    creditor += parseFloat(parseInt($(this).val()) || 0);  // Or this.innerHTML, this.innerText
                });

                $('#creditor_value').val(creditor)

                return true;
            }


            // } else {
            //   return false;
            // }
        });
    </script>
    {{--    //////////// ///////////////////// end /////////////////////////////--}}




    {{------------------------- add-record-madeen ---------------------}}
    <script>
        jQuery(document).delegate('a.add-record-madeen', 'click', function(e) {




            e.preventDefault();
            var content = jQuery('#sample_table-madeen tr'),
                size = jQuery('#tbl_posts >tbody >tr').length + 1,
                element = null,
                element = content.clone();
            element.attr('id', 'rec-madeen-'+size);
            element.find('.delete-record-madeen').attr('data-id', size);
            element.appendTo('#tbl_posts_body');

            // element.find('select').select2()


            var debit = 0;
            $('.debit_value').each(function(){

                debit += parseFloat(parseInt($(this).val()) || 0);  // Or this.innerHTML, this.innerText
            });

            $('#debit_value').val(debit)

            var creditor = 0;
            $('.creditor_value').each(function(){
                creditor += parseFloat(parseInt($(this).val()) || 0);  // Or this.innerHTML, this.innerText
            });

            $('#creditor_value').val(creditor)

            // $(body).querySelector('select').select2()
        });
        /***************/
        jQuery(document).delegate('a.delete-record-madeen', 'click', function(e) {

            var numdivs = $('.madeen').length;

            if (numdivs == 2){
                alert('لا يمكن الحذف')
            }else {
                e.preventDefault();
                // var didConfirm = confirm("Are you sure You want to delete");
                // if (didConfirm == true) {
                var id = jQuery(this).attr('data-id');
                var targetDiv = jQuery(this).attr('targetDiv');
                jQuery('#rec-madeen-' + id).remove();

                //regnerate index number on table
                $('#tbl_posts_body tr').each(function (index) {
                    //alert(index);
                    $(this).find('span.sn').html(index + 1);
                });


                var debit = 0;
                $('.debit_value').each(function(){

                    debit += parseFloat(parseInt($(this).val()) || 0);  // Or this.innerHTML, this.innerText

                });

                $('#debit_value').val(debit)

                var creditor = 0;
                $('.creditor_value').each(function(){
                    creditor += parseFloat(parseInt($(this).val()) || 0);  // Or this.innerHTML, this.innerText
                });

                $('#creditor_value').val(creditor)



                return true;
            }


            // } else {
            //   return false;
            // }
        });
    </script>
    {{--    //////////// ///////////////////// end /////////////////////////////--}}
    <script>
        $(document).on('keyup', '.change-elumnt', function () {
            var debit = 0;
            $('.debit_value').each(function(){

                debit += parseFloat(parseInt($(this).val()) || 0);  // Or this.innerHTML, this.innerText
            });

            $('#debit_value').val(debit)

            var creditor = 0;
            $('.creditor_value').each(function(){
                creditor += parseFloat(parseInt($(this).val()) || 0);  // Or this.innerHTML, this.innerText
            });

            $('#creditor_value').val(creditor)


        });
    </script>

@endsection
