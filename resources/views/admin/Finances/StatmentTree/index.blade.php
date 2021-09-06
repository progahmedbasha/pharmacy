
@extends('layouts.admin')

@section('styles')

@endsection

@section('page-title')
    شجرة الحسابات
@endsection

@section('current-page-name')
    شجرة الحسابات
@endsection

@section('page-links')
    <li class="breadcrumb-item active">
        <a href="{{route('admin.financesIndex.index')}}">الماليات</a>
    </li>
    <li class="breadcrumb-item active">شجرة الحسابات</li>
@endsection

@section('content')


    <link href="{{asset('admin')}}/css/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="{{asset('admin/css/select2.css')}}" rel="stylesheet">
    @include('layouts.loader.loaderCss')
<style>
    /* Remove default bullets */
    ul, #myUL {
        list-style-type: none;
    }

    /* Remove margins and padding from the parent ul */
    #myUL {
        margin: 0;
        padding: 0;
    }

    /* Style the caret/arrow */
    .caret {
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        /* Prevent text selection */
    }

    #start {
        padding: 6px 8px;
    }

    @media (max-width: 768px) {
        .nested {
            padding-right: 0;
            padding-left: 0;
        }
        .nested .btn {
            padding: 2px 6px;
        }
    }

    /* Create the caret/arrow with a unicode, and style it */
    .caret::before {
        content: "\25B6";
        -webkit-transform: rotate(180deg);
        transform: rotate(180deg);
        color: #8b8b8b;
        display: inline-block;
        margin-left: 6px;
    }

    /* Rotate the caret/arrow icon when clicked on (using JavaScript) */
    .caret-down::before {
        -webkit-transform: rotate(90deg);
        transform: rotate(90deg);
    }

    /* Hide the nested list */
    .nested {
        display: none;
    }

    .nested li {
        padding: 6px 10px;
        margin-bottom: 10px;
        border: 1px solid silver;
    }

    /* Show the nested list when the user clicks on the caret/arrow (with JavaScript) */
    .active {
        display: block;
    }
</style>

    <div id="messages"></div>
    <div id="notes"></div>
<div class="col-md-12">
    <div class="card">

        <ul id="myUL">
            <li  id="start"><span class="caret"> شجرة الحسابات</span>
                <div class="w-100 d-flex justify-content-end">
                    <button type="button" class="btn btn-info" style="margin: 10px;" data-toggle="modal" data-target="#add_modal">إضافة جديد</button>
                </div>
                <ul class="nested">
                    <!-- parent accounts-->

                    @foreach($accounts_tree as $main_account)
                        <li>
                            <span class="caret account_name_{{$main_account->id}}">{{$main_account->name}}</span>
                            <div class="d-flex" style="margin: 10px 0;">
                                <button class="btn btn-success edit-account" data-toggle="modal" data-target="#edit_account_modal" data-account_id="{{$main_account->id}}"><i class="fa fa-edit"></i></button>

                                <button class="btn mx-1 btn-default new_account" data-account_id="{{$main_account->id}}"><i class="fa fa-plus"></i></button>

                                @if($main_account->id >27)
                                    <form method="post" class="delete_form" action="{{ route('admin.accountsTree.destroy',$main_account->id) }}">
                                        {{ method_field('DELETE') }}
                                        {{  csrf_field() }}
                                        <button class="btn btn-danger delete_account"><i class="fa fa-trash"></i></button>
                                    </form>

                                @endif
                            </div>

                            @if(isset($main_account->children_accounts))
                                @include('admin.Finances.Reports.tree_level',['childs' => $main_account->children_accounts])
                            @endif
                        </li>
                    @endforeach
                </ul>
            </li>
        </ul>

    </div>
</div>
    <div class="modal fade" id="edit_account_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تعديل الحساب</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" class="edit_form">
                        <div class="row">
                            <div class="col-lg-6 col-md-6  mb-6">
                                <label class="label mb-2 " for="code"> إسم الحساب </label>
                                <input id="edit_name" name="name"  type="text" class="form-control edit_account_name" data-validation="required">
                                @error('name')
                                {{@message}}
                                @enderror
                            </div>
                            <input type="hidden" name="account_id" id="account_id" />


                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12  mb-12">
                                <button type="button" id="edit_account" class="btn btn-primary">تعديل</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">


                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">إضافة حساب جديد</h5>
                    <button type="button" class="close dissmiss_modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" class="add_submit">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-6  mb-6">
                                <label class="label mb-2 " for="code"> إسم الحساب </label>
                                <input id="name" name="name"  type="text" class="form-control" data-validation="required">
                                @error('name')
                                {{@message}}
                                @enderror
                            </div>

                            <div class="col-lg-6 col-md-6  mb-6">
                                <label for="recipient-name" class="form-control-label">إختر نوع الحساب :</label>
                                <select name="account_type" class="form-control" id="account_type">

                                    <option value="debit">مدين</option>
                                    <option value="creditor">دائن</option>

                                </select>
                            </div>

                            <div class="col-lg-6 col-md-6  mb-6 parent_div" >
                                <label for="recipient-name" class="form-control-label">إختر المستوى الرئيسي :</label>
                                <select name="parent_account" class="form-control" id="parent_account">
                                    @foreach($accounts as $account)
                                        <option value="{{$account->id}}">{{$account->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-6 col-md-6  mb-6">
                                <label class="label mb-2 " for="code"> كود الحساب </label>
                                <input id="code" name="code" readonly type="text" class="form-control" data-validation="required">
                            </div>

                            <div class="col-lg-6 col-md-6  mb-6">
                                <label class="label mb-2 " for="level"> المستوى </label>
                                <input id="level" name="level" readonly type="text" class="form-control" data-validation="required">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12  mb-12">
                                <button type="button" id="add_submit" class="btn btn-primary">إضافة</button>
                                <button type="button" class="btn btn-secondary dissmiss_modal" data-dismiss="modal">إلغاء</button>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">


                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        var toggler = document.getElementsByClassName("caret");
        var i;

        for (i = 0; i < toggler.length; i++) {
            toggler[i].addEventListener("click", function () {
                this.parentElement.querySelector(".nested").classList.toggle("active");
                this.classList.toggle("caret-down");
            });
        }

        /****parent_account script***/
        $('body').on('change', '#parent_account', function() {
            var selected_parent = $( "#parent_account option:selected" ).val();
            set_account_code(selected_parent);
        });

        $( document ).ready(function() {
            var selected_parent = $( "#parent_account option:selected" ).val();
            set_account_code(selected_parent);
        });

        function set_account_code(parent_id)
        {
            var url= "{{route('admin.getAccountCode')}}"+"?is_parent=child&parent_id="+parent_id;
            $.ajax({
                url:url,
                type: 'get',
                success: function (data) {
                    $('#code').val(data.code)
                    $('#level').val(data.level)
                },
                error: function (data) {


                },//end error method

                cache: false,
                contentType: false,
                processData: false
            });
        }
        /***********************************/

        /****submit add account****/
        $('body').on('click', '#add_submit', function(e) {
            e.preventDefault();

            var postData = $('.add_submit').serializeArray();

            $.post("{{route('admin.accountsTree.store')}}",postData, function(result){
                //failed
                if(result['status'] == 'error')
                {
                    toastr.error(result['message'],'خطأ')
                }
                else
                {
                    //success
                    $('#submit_form').trigger("reset");

                    var selected_parent = $( "#parent_account option:selected" ).val();
                    set_account_code(selected_parent);

                    $('#add_modal').modal('hide')

                    toastr.success(result['message'],'نجح')

                    location.reload()
                }
            });
        });
        /***********************************/

        /**********EDIT ACCOUNT**************/
        //show edit form
        $(document).on('click','.edit-account',function (e) {
            e.preventDefault();
            var id = $( this ).data( "account_id");
            //set name value
            $('.edit_account_name').val($('.account_name_'+id).text());
            $('#account_id').val(id);
        });

        //submit edit form

        $('body').on('click', '#edit_account', function(e) {
            e.preventDefault();

            var postData = $(this).closest('.edit_form').serializeArray();
            //console.log(postData);
            //console.log($('#account_id').val());

            var account_id = $('#account_id').val();
            var url = '{{ route("admin.accountsTree.update", ":account_id") }}';
            url = url.replace(':account_id', account_id);

            //console.log(url);

            $.ajax({
                type: 'PUT',
                url: url,
                contentType: "json",
                headers: {'x-csrf-token': _token},
                data: JSON.stringify(postData), // access in body
            }).done(function (result) {
                //failed
                if(result['status'] == 'error')
                {
                    toastr.error(result['message'],'خطأ')
                }
                else
                {
                    //success

                    //update name in tree
                    $('.account_name_'+account_id).html($('#edit_name').val());
                    $('#edit_account_modal').modal('hide')
                    toastr.success(result['message'],'نجح')
                }
            }).fail(function (msg) {
                //fail
                myToast('خطأ', 'حدث خطأ أثناء التحديث', 'top-center', '#ff6849', 'error', 4000, 2);
            });
        });

        /***********************************/


        /***************Add accounts to sub levels********************/



        $('body').on('click', '.new_account', function(e) {
            e.preventDefault();

            var account_id = $( this ).data("account_id");

            if(account_id)
            {
                //set parent id value
                $('.parent_div').hide();
                //$("#parent_account").remove();
                $('#add_submit').append('<input type="hidden" id="parent_account" name="parent_account" value="'+account_id+'" />');

            }

            $('#add_modal').modal('show');

        });

        $('body').on('click', '.dissmiss_modal', function(e) {
            $('#add_modal').modal('hide');
            location.reload();
        })
        /***************END DELETE ACCOUNT********************/


    </script>


@endsection

