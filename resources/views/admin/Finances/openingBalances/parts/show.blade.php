


    <div class="row mt-2 mb-2 p-3 text-center">
        <button type="button" class="btn d-flex btn-light-success w-100 d-block text-info font-weight-medium">
            تفاصيل قيد يومى
        </button>
    </div>

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
