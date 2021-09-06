@extends('admin.layouts.layout')

@section('styles')
    <link href="{{asset('admin')}}/css/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="{{asset('admin/css/select2.css')}}" rel="stylesheet">
    @include('admin.layouts.loader.loaderCss')
@endsection

@section('page-title')
    الأرصدة الإفتتاحية
@endsection

@section('current-page-name')
    الأرصدة الإفتتاحية
@endsection

@section('page-links')
    <li class="breadcrumb-item active">
        <a href="{{route('financesIndex.index')}}">الماليات</a>
    </li>
    <li class="breadcrumb-item active">   الأرصدة الإفتتاحية </li>
@endsection

@section('content')

    <div id="messages"></div>
    <div id="notes"></div>
    <section class="brands-page my-5">

        <!-- basic table -->
        <div class="row">
            <div class="col-12 mb-2">
                @if($count == 0)
                <button id="addButton" class="btn mb-2 btn-success "> أضف <span class="icon-add_circle"></span>  </button>
                @else
                    <button  class='btn mb-2 btn-secondary editButton' id='{{$find->id}}'> <i class='fad fa-edit'></i></button>
                @endif
{{--                <button id="bulk_delete" class="btn mb-2 btn-danger"> حذف الكل <span class="icon-delete"></span>  </button>--}}
            </div>
            <div class="col-12">
                <div class="card">
                    @if($count != 0)

                    <div class="card-body">


                        <div class="row">

                            <div class="table-responsive-md col-sm-12">
                                <table class="table  table-bordered" >
                                    <thead>
                                    <tr>
                                        <th>رقم القيد</th>
                                        <th>تاريخ القيد</th>
                                        <th>اسم الحساب</th>
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
                                            @endif
                                            <td>{{$contain_details->account_rl->name}}</td>
                                            <td>{{$contain_details->debit_value}}</td>
                                            <td>{{$contain_details->creditor_value}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th colspan="3"><h4 style="text-align: center"> الإجمالى </h4></th>
                                        <th>{{$find->value}}</th>
                                        <th>{{$find->value}}</th>
                                    </tr>
                                    </tfoot>
                                </table>

                            </div>
                        </div>

                    </div>
                    @endif

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

                        <button type="button" class="btn btn-light-danger text-danger font-weight-medium waves-effect text-start" data-bs-dismiss="modal">الغاء</button>

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

                        <button type="button" class="btn btn-light-danger text-danger font-weight-medium waves-effect text-start" data-bs-dismiss="modal">الغاء</button>

                    </div>
                </div>
            </div>
        </div>


    </section>


@endsection

@section('js')
    <script src="{{asset('admin')}}/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('admin/backEndFiles/repeater/jquery.repeater.min.js')}}"></script>
    <script src="{{asset('admin/js/select2.js')}}"></script>

    <script>
        var items_array = [];
    </script>

    <script>

        //========================================================================
        //========================================================================
        //==============================  datatable ==============================
        //========================================================================
        //========================================================================

        var messages = $('#messages').notify({
            type: 'messages',
            removeIcon: '<i class="icon-close"></i>'
        });

        $(document).on('change', '.newSelect', function () {


        });






        $(document).on('click','#addButton',function (e) {
            e.preventDefault()
            $('#save').show()
            var url = '{{route('openingBalances.create')}}';
            $.ajax({
                url: url,
                type: 'GET',
                beforeSend: function(){
                    $('.loader-ajax').show()
                },
                success: function(data){
                    window.setTimeout(function() {
                        $('.loader-ajax').hide()

                        if (data == 50000){
                            messages.show("لا يمكن الإضافة..", {
                                type: 'info',
                                title: '',
                                icon: '<i class="icon-error"></i>',
                                delay:2000,
                            });
                        }else {
                            $('#form-for-addOrDelete').html(data.html);
                            $('#exampleModalCenter').modal('show')
                            $('.dropify').dropify();
                            $('.FindSelect select').select2()
                        }


                        $.validate({
                        });
                        items_array = []
                        $('.ItemSelected').each(function(){
                            items_array.push(this.value);
                        });
                        $("#save").show()
                    }, 100);
                },
                error: function(jqXHR,error, errorThrown) {
                    $('.loader-ajax').hide()
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
            $('#save').show()
            e.preventDefault()
            var id = $(this).attr('id');

            var url = '{{route('openingBalances.edit',":id")}}';
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
                        $('#tbl_posts_body').find('select').select2()

                        items_array = []
                        $('.ItemSelected').each(function(){
                            items_array.push(this.value);
                        });
                        $("#save").show()
                    }, 100);
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

                                window.location.reload()

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


    </script>



    {{------------------------- add-record-dayyen ---------------------}}
    <script>
        jQuery(document).delegate('a.add-record-dayyen', 'click', function(e) {



            e.preventDefault();

            var IDarray = []
            $('.SelectAccount').each(function(){
                IDarray.push(this.value)
            });

            var content = jQuery('#sample_table-dayyen tr'),
                size = jQuery('#tbl_posts >tbody >tr').length + 1,
                element = null,
                element = content.clone();
            element.attr('id', 'rec-dayyen-'+size);
            element.find('.delete-record-dayyen').attr('data-id', size);
            element.appendTo('#tbl_posts_body');

            element.find('select').select2()


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


            var IDarray = []
            $('.SelectAccount').each(function(){
                IDarray.push(this.value)
            });

            var content = jQuery('#sample_table-madeen tr'),
                size = jQuery('#tbl_posts >tbody >tr').length + 1,
                element = null,
                element = content.clone();
            element.attr('id', 'rec-madeen-'+size);
            element.find('.delete-record-madeen').attr('data-id', size);
            element.appendTo('#tbl_posts_body');

            element.find('select').select2()


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

            $(body).querySelector('select').select2()
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
        @if($count == 0)
        $(document).ready(function (){
            $('#addButton').click()
        })
        @endif


    </script>

@endsection
