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
@endsection

@section('content')

    <section class="item-movement-page my-3 py-4" style="background-color: white;">

        <div class="alert alert-danger error_msg" role="alert" style="display: none;">

        </div>

            <div class="card">
                <div class="card-header">
                    {{ trans('Finances.incomeList') }}
                </div>
                <form enctype="multipart/form-data" target="_blank" action="{{route('admin.incomeList.update',0)}}" method="POST">
                    <div class="row" style="margin: 10px">

                        @csrf

                        @method('PUT')
                    <div class="col-lg-3 col-md-6  mb-3">
                                <label class="label mb-2 " for="FromDate">من تاريخ</label>
                                <input type="date" name="FromDate" id="FromDate" value="{{date('Y-m-d', strtotime("-90 days"))}}" placeholder="من تاريخ" class="form-control search-keys" required >
                            </div>

                            <div class="col-lg-3 col-md-6  mb-3">
                                <label class="label mb-2 " for="ToDate">إلى تاريخ..</label>
                                <input type="date" value="{{date('Y-m-d')}}"  name="ToDate" id="ToDate" placeholder="إلى تاريخ" class="form-control search-keys" required>
                            </div>
                            <div class="w-100 pb-3 d-flex align-items-center justify-content-center col-sm-3">
                                <button type="button" id="SearchSubmit" class="btn btn-info"> بحث </button>

                                <button type="submit" style="margin-right: 10px" id="ButtonSubmit" class="btn btn-secondary"> طباعة </button>

                            </div>

            <div class="table-responsive-md col-sm-12" id="TableSearch" style="display: none">

                <div class="p-3 bg-gray">
                    <h4 class="font-weight-bold text-center"> قائمة الدخل  </h4>
              <div class="text-center">
                  <p style="display: inline-block"  id="FromText"></p>

                  <p style="display: inline-block;margin-right: 20px" id="ToText"></p>
              </div>
                </div>


                <table class="table table-striped-table-bordered table-hover table-checkable table-" id="tbl_posts">
                    <thead>
                    <tr>
                    </tr>
                    </thead>
                    <tbody id="tbl_posts_body">

                    </tbody>

                </table>
            </div>

                    </div>
                </form>
        </div>




    </section>
@endsection

@section('scripts')
    <script>
        $(document).on('click','#SearchSubmit',function(e){
            e.preventDefault();

            var postData = {
                FromDate : $('#FromDate').val(),
                ToDate : $('#ToDate').val(),
                _token:"{{csrf_token()}}"

            };



            $.post("{{@route('admin.incomeList.store')}}", postData, function(result)
            {
                if(result['status'] == 'yes')
                {
                    $('#ToText').html( ' إلى '+ " " + $('#ToDate').val() )

                    $('#FromText').html( 'من '+ " " + $('#FromDate').val() )

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
