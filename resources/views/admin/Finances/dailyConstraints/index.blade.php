@extends('layouts.admin')
@section('content')
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
            <a href="{{route('admin.dailyConstraints.create')}}" class="btn mb-2 btn-success "> أضف <span class="icon-add_circle"></span>  </a>

        </div>
    </div>
    <div class="card">
        <div class="card-header">
            {{ trans('Finances.dailyConstraints') }}
        </div>
        <div class="card-body">

        <div class="row">
                            <div class="col-lg-4 col-md-6  mb-4">
                                <label class="label mb-2 " for="dayeenSelect">حساب دائن</label>
                                <select class="form-control select2" multiple id="dayeenSelect">
                                    <option value="all" selected>الكل</option>
                                    @foreach($accounts as $account_dayyen)
                                        <option value="{{$account_dayyen->id}}">{{$account_dayyen->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4 col-md-6  mb-4">
                                <label class="label mb-2 " for="maddenSelect">حساب المدين</label>
                                <select class="form-control select2" multiple id="maddenSelect">
                                    <option value="all" selected>الكل</option>
                                    @foreach($accounts as $account_madden)
                                        <option value="{{$account_madden->id}}">{{$account_madden->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-4 col-md-6  mb-4">
                                <label class="label mb-2 " for="name">رقم القيد</label>
                                <input class="form-control numbersOnly" id="QuedNumber" type="text" placeholder="رقم القيد">
                            </div>
                            <div class="col-lg-4 col-md-6  mb-4">
                                <label class="label mb-2 " for="name">من</label>
                                <input class="form-control " id="FromDate" type="date" placeholder="">
                            </div>
                            <div class="col-lg-4 col-md-6  mb-4">
                                <label class="label mb-2 " for="name">إلى</label>
                                <input class="form-control " id="ToDate" type="date" placeholder="">
                            </div>
                            <div class="col-lg-4 col-md-6  mb-4">
                                <button type="button" id="SearchButton" class="btn btn-info" style="margin-top: 8%"> بحث </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table  id="test" class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-ShippingAndClearance" >

                                <thead>
                                <tr>
                                    <th width="10px" class="not-exported">

                                    </th>
                                    <th>م</th>
                                    <th>القيمة</th>
                                    <th>التاريخ</th>
                                    <th>وقت الإضافة</th>
                                    <th  class="not-exported">التحكم</th>

                                </tr>
                                </thead>
                                <tbody id="Tobody">

                                </tbody>
                                <tfoot>
                                <tr>
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


    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
    <script src="{{asset('admin/backEndFiles/sweetalert/sweetalert.min.js')}}"></script>

    <script>


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
                },{
                    extend:'pdf',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible',
                        text:'pdf'
                    }
                },{
                    extend:'excel',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible',
                        text:'excel'
                    }
                },{
                    extend:'csv',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible',
                        text:'csv'
                    }
                }
            ],
            initComplete: function () {
                this.api().columns([1,2,3,4]).every(function () {
                    var column = this;
                    var search = $(`<input style="font-size: 85%;height: 15px;width: 100%" class="form-control form-control-sm" type="text" placeholder="بحث .... ">`)
                        .appendTo($(column.footer()).empty())
                        .on('change input', function () {
                            var val = $(this).val()

                            column
                                .search(val ? val : '', true, false)
                                .draw();
                        });
                });
            },
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
        $(document).on('click', '.delete', function () {
            var id = $(this).attr('id')
           var op = $(this)
                var url = '{{ route("admin.dailyConstraints.destroy", ":id") }}';
                url = url.replace(':id', id);
                console.log(url);
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    headers: {'x-csrf-token': _token},
                    data: {id: id},
                    success: function (data) {

                        toastr.info('تم الحذف')

                        if (op.attr('attr_type') == 'search'){
                            $('#SearchButton').click()
                        }else {
                            $('#basicExample').DataTable().ajax.reload();
                        }

                    },error: function(data) {
                        toastr.error('هناك خطأ ما!!')
                    }
                    })

            })




        $(document).on('click','#SearchButton',function (e) {
            e.preventDefault()

            var FromDate = $('#FromDate').val()
            var ToDate = $('#ToDate').val()
            var dayeenSelect = $('#dayeenSelect').val()
            var maddenSelect = $('#maddenSelect').val()
            var QuedNumber = $('#QuedNumber').val()

            var id = $(this).attr('id');

            var url = '{{route('admin.dailyConstraints.Search')}}';

            $.ajax({
                type: 'POST',
                headers: {'x-csrf-token': _token},
                url: url,
                data: {"FromDate": FromDate,"ToDate":ToDate,'QuedNumber':QuedNumber
                    ,"dayeenSelect[]":dayeenSelect,"maddenSelect[]":maddenSelect,"_token":"{{csrf_token()}}"
                },
                beforeSend: function(){

                    $('.loader-ajax').show()
                },
                success: function (data) {

                    window.setTimeout(function() {


                        console.log(data)
                        $('#Tobody').html(data.html)

                        $('.loader-ajax').hide()

                        $('.linear-background').hide()



                    }, 100);





                },
                error: function (error) {
                    if (error.status == 500){
                        swal("ليست لديك الصلاحية للبحث", {
                            icon: "error",
                        })
                    }

                    else{
                        swal("هناك خطأ ما", {
                            icon: "error",
                        })
                    }
                }
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
