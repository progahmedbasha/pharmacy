@extends('layouts.admin')

@section('styles')

@endsection

@section('page-title')
   ميزان المراجعة
@endsection

@section('current-page-name')
    ميزان المراجعة
@endsection

@section('page-links')
    <li class="breadcrumb-item active">ميزان المراجعة</li>
@endsection

@section('content')

    <section class="item-movement-page my-3 py-4" style="background-color: white;">

        <div class="alert alert-danger error_msg" role="alert" style="display: none;">

        </div>
        <div class="card">
            <div class="card-header">
                {{ trans('Finances.TrialBalance') }}
            </div>
            <div class="row" style="margin: 10px">



            <div class="col-lg-3 col-md-6  mb-3">
                <label class="label mb-2 " for="FromDate">من تاريخ</label>
                <input type="date"  id="FromDate" placeholder="من تاريخ" class="form-control search-keys" required >
            </div>

            <div class="col-lg-3 col-md-6  mb-3">
                <label class="label mb-2 " for="ToDate">إلى تاريخ..</label>
                <input type="date"  id="ToDate" placeholder="إلى تاريخ" class="form-control search-keys" required>
            </div>

            <div class="col-lg-3 col-md-6  mb-3">
                <label class="label mb-2 " for="firstPeriodBalance"> النوع </label>
                <select class=" select2" id="type" name="type" required>
                        <option value="1">مستوى أول</option>
                        <option value="2">مستوى ثانى</option>
                        <option value="3">مستوى ثالث</option>
                        <option value="4">تفصيلى</option>
                </select>
            </div>


            <div class="col-lg-2 col-md-6  mb-2">
                <label class="label mb-2 " for="hideZeroAccounts"> إخفاء الأرقام الصفرية </label>
                <select class=" select2" id="hideZeroAccounts" name="hideZeroAccounts" required>
                        <option value="1">نعم</option>
                        <option value="0">لا</option>
                </select>
            </div>

            <div class="w-100 pb-3 d-flex align-items-center justify-content-center col-sm-1">
                <button type="button" id="SearchSubmit" class="btn btn-info"> بحث </button>

            </div>


            <div class="table-responsive-md col-sm-12" id="TableSearch" style="display: none">

                <table class="table table-striped-table-bordered table-hover table-checkable table-" id="tbl_posts">
                    <thead>
                    <tr>
                        <th>كود الحساب</th>
                        <th> إسم الحساب</th>
                        <th>طبيعة الحساب</th>
                        <th class="first_period_field"> رصيد أول مدة مدين</th>
                        <th class="first_period_field">رصيد أول مدة دائن</th>
                        <th> رصيد فترة مدين</th>
                        <th> رصيد فترة دائن</th>
                        <th>إجمالى مدين</th>
                        <th>إجمالى دائن</th>
                        <th>رصيد المدين</th>
                        <th>رصيد الدائن</th>

                    </tr>
                    </thead>
                    <tbody id="tbl_posts_body">

                    </tbody>

                </table>
            </div>


        </div>

        </div>


    </section>
@endsection

@section('scripts')
    <script>

        //submit form script

        $(document).on('click','#SearchSubmit',function(e){
            e.preventDefault();

            var postData = {
                  FromDate : $('#FromDate').val(),
                  ToDate : $('#ToDate').val(),
                  firstPeriodBalance : $( "#firstPeriodBalance option:selected" ).val(),
                  hideZeroAccounts : $( "#hideZeroAccounts option:selected" ).val(),
                  type : $( "#type option:selected" ).val(),
                _token:"{{csrf_token()}}"

            };



            $.post("{{@route('admin.TrialBalanceFilter')}}", postData, function(result)
            {
                if(result['status'] == 'yes')
                {
                    if($( "#firstPeriodBalance option:selected" ).val() == 1)
                    {
                        $('.first_period_field').show();
                    }
                    else
                    {
                        $('.first_period_field').hide();
                    }
                    $('#TableSearch').show();
                    $('#tbl_posts_body').html(result['data']);
                    $('.error_msg').hide();
                }
                else
                {
                    $('.error_msg').html(result['message']);
                    $('.error_msg').show();
                }

            }, 'json');
        });

    </script>
@endsection
