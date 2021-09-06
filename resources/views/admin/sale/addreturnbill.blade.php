@extends('admin.layouts.header')

@section('content')



<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

<style>
input[type=date]{
width:130px;
font-size:10px;
 }

#com_info{
display:none;
}

.select2-container .select2-selection--single {

height:40px;
  }
  </style>


        <div class="analytics-sparkle-area">
            <div class="container-fluid">
@if(Session::has('id'))
<!-- The Modal -->
<div class="modal" id="myModalprint">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal body -->
      <div class="modal-body">
        <iframe src="{{url('printsalebill')}}/{{ Session::get('id') }}"></iframe>
      </div>
    </div>
  </div>
</div>
@endif
      <br>

<div class="panel panel-default">
  <div class="panel-heading">اضافة فاتورة</div>
  <div class="panel-body">
<form action="{{route('add_return_bill')}}"  method="post">
@csrf
<div class="row">

<input type="hidden" class="form-control"  name="bill_source" value="1" />
<input type="hidden" class="form-control" id="billInput" name="bill_id" value="" />



<div class="col-md-4">
    <div class="form-group">
      <label for="email">اختر رقم الفاتورة</label><br>
        <input class="form-control numbersOnly" id="bill_id"  required autofocus>

{{--      <select class="form-control select2"  id="bill_id" required >--}}
{{--        <option >إختر رقم فاتورة البيع</option>--}}
{{--        @foreach($bills as $bill)--}}
{{--        <option value="{{$bill->id}}">{{$bill->bill_number}}</option>--}}
{{--        @endforeach--}}
{{--    </select>--}}
    </div>
</div>


<div class="col-md-2">
    <div class="form-group">
      <label for="pwd">تاريخ الإرجاع</label>
      <input type="date" class="form-control" name="return_date" value="{{date('Y-m-d')}}" required>
    </div>
</div>

<div class="col-md-2">
    <div class="form-group">
      <label for="pwd">رقم فاتورة الإرجاع</label>
      <input type="text" class="form-control" name="return_number" readonly  value="

<?php

      try {
          echo \App\Models\ReturnSaleBill::latest()->first()->id + 1;
      }catch (Exception $exception){
          echo 1;
      }

      ?>

" required>
    </div>
</div>






</div>


<div class="row">
 <div class="col-sm-12">
<br><!--<button type="button" name="add" id="add" class="btn btn-success add"><i class="fa fa-plus"></i></button><br><br>-->

<div class="table-responsive">
        <table class="table table-bordered table-striped main" id="dynamicTable">
            <tr>
                <th style="width:150px;">اســـم المنتـــج</th>
                <th>السعر</th>

                <th>الكمية</th>
                <th>الخصم</th>
                <th>قيمة الضريبة</th>
                <th>الاجمالي</th>

            </tr>
        </table>
    </div>
</div>
</div>
<br>

<div class="row">
<div class="col-md-2">
    <div class="form-group">
      <label for="email">إجمالي الاصناف</label>
      <input type="number" class="form-control" name="pro_count" value="0" id="pro_count" required readonly>
    </div>
</div>

<div class="col-md-2">
    <div class="form-group">
      <label for="pwd">إجمالي الخصم</label>
      <input type="number" class="form-control" id="total_discount" value="0" name="total_discount" required readonly>
    </div>
</div>

<div class="col-md-2">
    <div class="form-group">
      <label for="pwd">الإجمالي قبل الضريبة</label>
      <input type="number" step="0.001" class="form-control" id="total_before_tax" value="0" name="total_before_tax" readonly>
    </div>
</div>

<div class="col-md-2">
    <div class="form-group">
      <label for="pwd">إجمالي الضريبة</label>
      <input type="number" step="0.001" class="form-control" id="total_tax" value="0" name="total_tax" readonly>
    </div>
</div>


<div class="col-md-2">
    <div class="form-group">
      <label for="email"> الإجمالي النهائي</label>
      <input type="number" step="0.001" class="form-control" name="final_total" value="0" id="final_total" required readonly>
    </div>
</div>


</div>

<div class="row">







</div>

<div class="row">
   <div class="col-md-6">
      <button type="submit" class="btn btn-primary" >حفظ</button>
 &nbsp;
 <!--<button type="button" class="btn btn-danger" onclick=''>إلغاء</button>-->
  <a href="{{url()->previous()}}" type="button" class="btn btn-danger" style="margin-top: 0px;">إلغاء</a>
</div>
</div>

  </form>
</div>
</div>

</div>

</div>

<script>
  //onchange bill number , show bill products
  $('#bill_id').keyup(function(){
      var op = $(this);
    var bill_id = $(this).val();


    postData = {
        bill_id : bill_id,
        "_token":"{{ csrf_token() }}"
    };
    $.post("{{route('bill_details_ajax')}}", postData , function(bill_data){
        console.log(bill_data);  //[0].bill_items

        if (bill_data.status == 1){
            bill_data = bill_data.value_;

            //main data
            $('#pro_count').val(bill_data['bill_items'].length);
            $('#total_discount').val(bill_data['total_discount']);
            $('#total_before_tax').val(bill_data['total_before_tax']);
            $('#total_tax').val(bill_data['total_tax']);
            $('#final_total').val(bill_data['total_final']);

            //products
            products = '';
            $.each(bill_data['bill_items'], function( index, value ) {
                products += '<tr><td>'+value['item']['name'] +'</td>'+
                    '<td>'+value['price']+'</td>'+
                    '<td>'+value['quantity']+'</td>'+
                    '<td>'+value['product_discount']+'</td>'+
                    '<td>'+value['tax_value']+'</td>'+
                    '<td>'+value['total_price']+'</td>'+
                    +'</tr>';
            });




            $("#billInput").val(bill_id)

            $("#bill_id").prop("disabled", true )



            $('#dynamicTable tr:last').after(products);
        }else{
            alert('تم الإرجاع مسبقاً')
        }



    }, 'json');
  })
</script>

<!---------------------- table --------------------------------------->

<script type="text/javascript">

</script>


<!---------------------- product --------------------------------------->

<script>






</script>

<!---------------------- finals --------------------------------------->

<script type="text/javascript">


    $(document).on('keyup','.numbersOnly',function () {
        this.value = this.value.replace(/[^0-9\.]/g,'');
    });
</script>

<!---------------------- validation --------------------------------------->
<script>

</script>
    @endsection

