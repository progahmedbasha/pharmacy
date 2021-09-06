<form action="{{route('openingBalances.update',$find->id)}}" method="post" id="Form">
    @csrf
    @method('PUT')


    <div class="row mt-2 mb-2 p-3 text-center">
        <button type="button" class="btn d-flex btn-light-success w-100 d-block text-info font-weight-medium">
            تعديل الرصيد الإفتتاحى
        </button>
    </div>

    <div class="row">


        <div class="col-lg-4 col-md-6  mb-4">
            <label class="label mb-2 " for="name">رقم القيد</label>
            <input type="text"  disabled value="{{$find->id}}" class="form-control" data-validation="required">
        </div>
        <div class="col-lg-4 col-md-6  mb-4">
            <label class="label mb-2 " for="name">التاريخ</label>
            <input type="date"  name="date" value="{{$find->date}}" class="form-control" data-validation="required">
        </div>
        <input type="hidden" name="type" value="first_balance">
        <div class="table-responsive-md col-sm-12">
            <table class="table table-striped-table-bordered table-hover table-checkable table-" id="tbl_posts">
                <thead>
                <tr>

                    <th>   مدين   <a class="btn btn-info add-record-madeen click" data-added="0" style="float: left!important;"><i class="fa fa-plus"></i></a> </th>
                    <th>   دائن   <a class="btn btn-info add-record-dayyen click" data-added="0" style="float: left!important;"><i class="fa fa-plus"></i></a> </th>
                    <th >إسم الحساب</th>
                    <th ></th>
                </tr>
                </thead>
                <tbody id="tbl_posts_body">

                @foreach($find->contain_details->where('type','debit') as $key =>$debit_details)
                <tr id="rec-madeen-{{$key + 1}}" class="madeen">
                    <td>
                        <input type="text" value="{{$debit_details->debit_value}}" name="debit_value[]" data-validation="required" class="form-control numbersOnly change-elumnt debit_value"  placeholder=" قيمة المدين..." >
                    </td>
                    <td>
                        ----
                    </td>
                    <td>
                        <select name="account_id_madeen[]" class="form-control newSelect" data-validation="required">
                            <option value="">إختر الحساب</option>
                            @foreach($accounts as $account)
                                <option value="{{$account->id}}" {{$account->id == $debit_details->account_id ?'selected':''}} >{{$account->name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><a class="btn btn-xs delete-record-madeen " data-id="{{$key + 1}}"><i style="color: #f4516c" class="fa fa-trash"></i></a></td>
                </tr>
                @endforeach

                @foreach($find->contain_details->where('type','creditor') as $key2 => $creditor_details)
                <tr id="rec-dayyen-{{$key2 + 1}}" class="dayyen">
                    <td>
                        ----
                    </td>
                    <td>
                        <input type="text" value="{{$creditor_details->creditor_value}}" name="creditor_value[]" data-validation="required" class="form-control numbersOnly creditor_value change-elumnt"  placeholder=" قيمة الدائن..." >
                    </td>
                    <td>
                        <select name="account_id_dayyen[]" class="form-control newSelect" data-validation="required">
                            <option value="">إختر الحساب</option>
                            @foreach($accounts as $account)
                                <option value="{{$account->id}}" {{$account->id == $creditor_details->account_id ?'selected':''}}>{{$account->name}}</option>
                            @endforeach
                        </select>
                    </td>

                    <td><a class="btn btn-xs delete-record-dayyen " data-id="{{$key2 + 1}}"><i style="color: #f4516c" class="fa fa-trash"></i></a></td>
                </tr>
                @endforeach

                </tbody>
                <tfoot>
                <tr>
                    <td><input class="form-control numbersOnly"  name="totalval" readonly id="debit_value" value="{{$find->value}}"></td>
                    <td><input class="form-control numbersOnly" readonly id="creditor_value" value="{{$find->value}}"></td>
                    <td colspan="3"><h3 style="text-align: center!important;">الإجمالى</h3></td>
                </tr>
                </tfoot>
            </table>

        </div>




    </div>


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

            <td><a class="btn btn-xs delete-record-madeen " data-id="1"><i style="color: #f4516c" class="fa fa-trash"></i></a></td>
        </tr>
    </table>
</div>
