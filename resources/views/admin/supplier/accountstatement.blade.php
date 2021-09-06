@extends('admin.layouts.header')

@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>


        <div class="analytics-sparkle-area">
            <div class="container-fluid">
			<br>
			كشف حساب عميل
			<br><br>
			
                <form method="get" class="form-inline" action="{{url('supplieraccountstatement')}}">

                 <div class="row">
                    <div class="col-md-4">
                        <select class="form-control select2"  name="supp_id" id="cus">
                            <!--<option >إختر العميل</option>-->
                            @foreach($suppliers as $value)
                            <option value="{{$value->id}}" {{($supplier == $value->id)?'selected':''}}>{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input  name="date_from" type="date" value="{{($from != null)?$from:date('Y-m-d')}}" required><br>
                    </div>
                    <div class="col-md-2">
                        <input  name="date_to" type="date" value="{{($to != null)?$to:date('Y-m-d')}}" required>
                    </div>
                        <div class="col-md-2">
                        <button type="submit">بحث</button>
                    </div></div>
                </form>
                
<br>
<div class="panel panel-default">
  <div class="panel-body">

    <div class="table-responsive">
<table class="table table-bordered" id="table_data">
    <thead>
      <tr>
        <th>#</th>
        <th>التاريخ</th>
        <th>العنوان</th>
		<th>الوصف</th>
		<th>دائن</th>
		<th>مدين</th>
		<th>الرصيد</th>
      </tr>
    </thead>
    <tbody>
        @if($statements != null)
        @foreach($statements->tree->entry_action as $index=>$statement)

      <tr>
        <td>{{$index+1}}</td>
        <td>{{$statement->entry->created_at}}</td>
        <td>{{$statement->entry->title}}</td>
		<td>{{$statement->entry->description}}</td>
        <td>{{$statement->credit}}</td>
		<td>{{$statement->debit}}</td>
        <td>{{$statement->balance}}</td>
      </tr>
      @endforeach
      @endif
    </tbody>
  </table>
</div>
            </div>
        </div>
 </div>
        </div>


<script>
  function selectRefresh() {
    $('.select2').select2({
      tags: true,
      placeholder: "Select an Option",
      allowClear: true,
      width: '100%'
    });
  }

  $(document).ready(function() {
    selectRefresh();
  });
</script>
    @endsection

