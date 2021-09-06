@extends('admin.layouts.layout')

@section('styles')
    <link href="{{asset('admin')}}/css/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="{{asset('admin/css/select2.css')}}" rel="stylesheet">
    @include('admin.layouts.loader.loaderCss')
@endsection

@section('page-title')
     حركة النقدية
@endsection

@section('current-page-name')
    حركة النقدية
@endsection

@section('page-links')
    <li class="breadcrumb-item active">
        <a href="{{route('financesIndex.index')}}">الماليات</a>
    </li>
    <li class="breadcrumb-item active">حركة النقدية</li>
@endsection

@section('content')

    <div id="messages"></div>
    <div id="notes"></div>
    <section class="brands-page my-5">

        <!-- basic table -->
        <div class="row">
            <div class="col-12 mb-2">
                {{--                <button id="addButton" class="btn mb-2 btn-success "> أضف <span class="icon-add_circle"></span>  </button>--}}
                {{--                <button id="bulk_delete" class="btn mb-2 btn-danger"> حذف الكل <span class="icon-delete"></span>  </button>--}}
            </div>
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <form action="{{route('cashMovement')}}" method="post" id="Form">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4 col-md-6  mb-4">
                                    <label class="label mb-2 " for="dayeenSelect">الخزنة</label>
                                    <select class="form-control select2" name="box" data-validation="required" >
                                        <option value="" selected>إختر</option>
                                        @foreach($boxes as $box)
                                            <option value="{{$box->id}}">{{$box->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-6  mb-2">
                                    <label class="label mb-2 " for="name">من</label>
                                    <input class="form-control " name="FromDate" id="FromDate" type="date" placeholder="">
                                </div>
                                <div class="col-lg-2 col-md-6  mb-2">
                                    <label class="label mb-2 " for="name">إلى</label>
                                    <input class="form-control " name="ToDate" id="ToDate" type="date" placeholder="">
                                </div>

                                <div class="col-lg-2 col-md-6  mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" value="creditor" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            دائن
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" value="debit" type="radio" name="flexRadioDefault" id="flexRadioDefault2" >
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            مدين
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" value="all" type="radio" name="flexRadioDefault" id="flexRadioDefault3" checked>
                                        <label class="form-check-label" for="flexRadioDefault3">
                                            الكل
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-6  mb-1">
                                    <button id="save"  form="Form"  type="submit" class="btn btn-info">بحث </button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table id="basicExample" style="display: none" class="table  table-bordered">

                                <thead>
                                <tr>
                                    <th>التاريخ</th>
                                    <th>رقم القيد</th>
                                    <th>نوع الحركة/الفاتورة/السند</th>
                                    <th>رقم الحركة</th>
                                    <th>البيان</th>
                                    <th>مدين</th>
                                    <th>دائن</th>
                                    <th>الرصيد</th>

                                </tr>
                                </thead>
                                <tbody id="Tobody">

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

                        if (data == 'error'){
                            $('#basicExample').hide()
                            messages.show("لا يوجد بيانات", {
                                type: 'warning',
                                title: '',
                                icon: '<i class="jq-icon-success"></i>',
                                delay:2000,
                            });
                        }else{

                            $('#basicExample').show()
                            $('#Tobody').html(data)
                        }



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



        });

    </script>


@endsection
