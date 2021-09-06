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
    <div class="panel panel-default">
  <div class="panel-heading">بيانات الطبيب</div>
  <div class="panel-body">
<div class="row">

<div class="col-md-4">
    <div class="form-group">
      <label for="email">اسم الطبيب</label><br>
       <input type="text" class="form-control" value="{{$pres->doctor->name}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">البريد الالكتروني</label><br>
       <input type="text" class="form-control" value="{{$pres->doctor->email}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">رقم الهاتف</label><br>
       <input type="text" class="form-control" value="{{$pres->doctor->phone}}" disabled>
    </div>
</div>


</div>

</div>
</div>


<div class="panel panel-default">
  <div class="panel-heading">بيانات المريض</div>
  <div class="panel-body">
<div class="row">

<div class="col-md-4">
    <div class="form-group">
      <label for="email">رقم الملف</label><br>
       <input type="text" class="form-control" value="{{$pres->patient->folder_number}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">اسم المريض</label><br>
       <input type="text" class="form-control" value="{{$pres->patient->patient_name}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">رقم الهاتف</label><br>
       <input type="text" class="form-control" value="{{$pres->patient->phone}}" disabled>
    </div>
</div>
</div>
</div>
</div>


<form action="{{route('new_prescription_bill')}}"  method="post">
@csrf

<div class="row">

<input type="hidden" class="form-control"  name="bill_source" value="1">
<input type="hidden" class="form-control"  name="pres_id" value="{{$pres->id}}">

<div class="col-md-4">
    <div class="form-group">
      <label for="email">اختر العميل</label><br>
      <select class="form-control select2"  name="cus_id" id="cus" onChange="get_cus_val()">
        <!--<option >إختر العميل</option>-->
        @foreach($customers as $value)
        <option value="{{$value->id}}">{{$value->name}} {{$value->tree->id_code}}</option>
        @endforeach
    </select>
    </div>
</div>

<div class="col-md-3">
    <div class="form-group">
      <label for="pwd">رصيد العميل</label>
      <input type="text" class="form-control"  name="cus_acc_no" id="cus_balance" value="{{$customers[0]->tree->balance}}" disabled>
    </div>
</div>

<div class="col-md-3">
  <div class="form-group">
    <label for="email">نوع الفاتورة</label>
      @if($customers[0]->type == 0)
        <input type="text"  class="form-control" name="stock_tracking" value="نقدي" id="cus_type" disabled>
      @else
      <input type="text"  class="form-control" name="stock_tracking" value="آجل" id="cus_type" disabled>
      @endif
  </div>
</div>

<div class="col-md-2">
    <div class="form-group">
      <label for="pwd">تاريخ الفاتورة</label>
      <input type="date" class="form-control" name="bill_date" value="{{date('Y-m-d')}}" required>
    </div>
</div>

</div>


<div class="row">
 <div class="col-sm-12">
<br><!--<button type="button" name="add" id="add" class="btn btn-success add"><i class="fa fa-plus"></i></button><br><br>-->
  <input type="text" class="form-control" id="barcodeScannerVal" onchange="barcode_scanner();"  oninput="this.onchange();" placeholder="Product Barcode" autofocus>
   <br><br>
<div class="table-responsive">
        <table class="table table-bordered table-striped main" id="dynamicTable">  
            <tr>
                <th style="width:150px;">اســـم المنتـــج</th>
                <th>السعر</th>
                <!--<th>الوحدة</th>-->
        <th>الكمية</th>
                <th>الخصم</th>
        <th>نوع الضريبة</th>
        <th>قيمة الضريبة</th>
        <th>الاجمالي</th>
        <th>حذف</th>
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

<div class="col-md-2">
    <div class="form-group">
      <label for="pwd">المبلغ المدفوع</label>
      <input type="number" step="0.001" class="form-control" name="paid_amount" value="0" id="paid_amount" onChange="set_remaining_amount()" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();" required>
    </div>
</div>
</div>

<div class="row">
<div class="col-md-2">
    <div class="form-group">
      <label for="pwd">المبلغ المتبقي</label>
      <input type="number" step="0.001" class="form-control" value="0" name="remaining_amount" id="remaining_amount" readonly>
    </div>
</div>


<div class="col-md-2">
    <div class="form-group">
      <label for="pwd">طريقة الدفع</label>
      <select class="form-control" name="pay_way">
        <option value="0">كاش</option>
         <option value="1">شبكة</option>
    </select>
    </div>
</div>

<div class="col-md-2">
    <div class="form-group">
      <label for="pwd">تاريخ الاستحقاق</label>
      <input type="date" class="form-control"  name="due_date" value="{{date('Y-m-d')}}">
    </div>
</div>

</div>

<div class="row">
   <div class="col-md-6">
      <button type="submit" class="btn btn-primary" id="save_validate" disabled="disabled">حفظ</button>
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
  var pro_quantity = 1;
  function selectRefresh() {
    $('.select2').select2({
      tags: true,
      placeholder: "Select an Option",
      allowClear: true,
      width: '100%'
    });
  }
  
  $(document).ready(function() {

  //var product_barcode = {{($pres->items)[0]->item->product->barcode}};
  var zz = <?php echo $pres->items ?> ;
  for(var j = 0; j < zz.length ;j++){
    var product_barcode = zz[j].item.product.barcode;
    pro_quantity = zz[j].quantity;
    get_pro_barcode(product_barcode,zz[j].quantity);
  }
  selectRefresh();
  });
</script>

<!---------------------- table --------------------------------------->

<script type="text/javascript">

/*$(document).ready(function(){
  
});
*/

 // function set_product_to_table(){}
</script>

<script type="text/javascript">
  var i = 0;
  var bill_products_list= new Array();

  function barcode_scanner() {
    var product_barcode = document.getElementById("barcodeScannerVal").value;

    if (product_barcode != '') {
        // GET every service Explanation section Details by serviceId
        get_pro_barcode(product_barcode,1);

      }
  }

  function get_pro_barcode(product_barcode,quantity){
    $.ajax({
            url: "{{url('ajax_search_barcode')}}/"+ product_barcode,
            dataType: 'json',
            type: 'GET',
            cache: false,
            async: true,
            success: function (data) {
              if(!data.error){
                pro_quantity = quantity;
                check_data(data.pro);
              }
              else{
                if(data.status == 1){
                  alert(data.message);
                  document.getElementById("barcodeScannerVal").value = '';
                }
              }
            },
            error: function (jqXhr, textStatus, errorThrown) {
                //console.log(errorThrown);
                //alert(errorThrown);
            }
        })

  }

  function check_data(data){
    if(bill_products_list.length == 0){
      set_product(data);
    }else{
      var pro_id = data.id;
      var found = false; var x=null;
      for(var j=0;j<bill_products_list.length;j++){
        if(bill_products_list[j] != null && bill_products_list[j].id == pro_id){
          found = true;
          x = j;
          break;
        }
      }
      if(found){
        document.getElementById("quantity"+x).value = parseInt(document.getElementById("quantity"+x).value) +1;
        document.getElementById("barcodeScannerVal").value = '';
        pro_total_pruce(x);
      }
      else{
        set_product(data);
      }
    }
  }

  function set_product(data){
    bill_products_list.push(data);
    if(data.item.isTax == 0)
    $isTaxview = '<td>غير خاضع"</td>';
    else
    $isTaxview = '<td>خاضع</td>';

    $('.main').append
    ('<tr>'+
    '<td>'+ data.item.name_ar +'<input type="hidden" value="'+data.item.id+'" name="multi_product[]"> </td>'+

    '<td><input type="number" step="0.001" value="'+data.item.default_sale_price+'"name="multi_price[]"  class="form-control" id="price'+i+'" onChange="price_tax('+i+')"  onpaste="this.onchange();" required/></td>'+

    '<td><input type="number" min="1" name="multi_amount[]"  class="form-control" value="'+pro_quantity+'" id="quantity'+i+'" onChange="pro_total_pruce('+i+')" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();" required/></td>'+

    '<td><input type="number" name="multi_discount[]"  class="form-control" value="'+data.item.default_discount+'" id="discount'+i+'" onChange="pro_total_pruce('+i+')" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();" required/></td>'+

    $isTaxview+

    '<td><input type="number" step="0.001" name="multi_tax_val[]"  class="form-control" value="0" id="taxval'+i+'" readonly></td>'+

    '</td> <td><input type="number" step="0.001" name="multi_total[]" value="0" class="form-control" id="pro_total'+i+'" readonly/>'+

    '<td><button type="button" class="btn btn-danger" onclick="deleteCurrentRow(this,'+i+')"><i class="fa fa-trash"></i></button></td>'+
    '</tr>'); 
    price_tax(i);
    ++i;
    document.getElementById("barcodeScannerVal").value = '';
    set_pro_count();
  }

  function deleteCurrentRow(event,k){
    $(event).parents('tr').remove();

    bill_products_list[k]=null;

    set_pro_count();
    set_total_discount();
    set_total_before_tax();
    set_total_tax();
    set_final_total();
    validate_bill_save();
  }
</script>


<!---------------------- product --------------------------------------->

<script>

  function price_tax(k){
    var tax = <?php echo $tax;?>;
    if(tax.tax_type == 1 && bill_products_list[k].item.isTax == 1){
      var y = calc_tax(document.getElementById("price"+k).value);
      document.getElementById("price"+k).value = (document.getElementById("price"+k).value - y).toFixed(2);
    }
    pro_total_pruce(k);
  }

  function pro_total_pruce(k){
    if(parseInt(document.getElementById("quantity"+k).value) > bill_products_list[k].total_quantity)
      document.getElementById("quantity"+k).value = bill_products_list[k].total_quantity;
    get_tax_val(k);
    var x = ((document.getElementById("price"+k).value * document.getElementById("quantity"+k).value) - document.getElementById("discount"+k).value);
    var y = x + parseFloat(document.getElementById("taxval"+k).value);
    document.getElementById("pro_total"+k).value = y.toFixed(2);

    set_total_discount();
    set_total_before_tax();
    set_total_tax();
    set_final_total();
  }

  function get_tax_val(k){
    var tax = <?php echo $tax;?>;
    if(bill_products_list[k].item.isTax == 1){
      var y = (document.getElementById("price"+k).value * document.getElementById("quantity"+k).value) - document.getElementById("discount"+k).value;
      var z = (tax.tax_value / 100) * y;
      document.getElementById("taxval"+k).value = z.toFixed(2);
    }
  }

  function calc_tax(val){
    tax = <?php echo $tax;?>;
    return (((tax.tax_value / 100) * val)/(1 + (tax.tax_value / 100))).toFixed(2);
  }
  
  function get_cus_val(){
    var cus = <?php echo $customers; ?>

    var ids = document.getElementById("cus").value;

    var elementPos = cus.findIndex(x => x.id == ids);
    var objectFound = cus[elementPos];

    document.getElementById("cus_balance").value = objectFound.tree.balance;
    if(objectFound.type == 0)
      document.getElementById("cus_type").value = "نقدي";
    else
      document.getElementById("cus_type").value = "آجل";

    validate_bill_save();

  }
    
</script>

<!---------------------- finals --------------------------------------->

<script type="text/javascript">

  function set_pro_count(){
    var x = document.getElementsByName("multi_product[]").length;
    document.getElementById("pro_count").value = x;
  }

  function set_total_discount(){
    var y = document.getElementsByName("multi_discount[]");
    var ty = 0;
    for(var i = 0 ; i < y.length ; i++){
      ty += parseInt(y[i].value);
    }
    document.getElementById("total_discount").value = ty;
  }

  function set_total_before_tax(){
    var x = document.getElementsByName("multi_price[]");
    var y = document.getElementsByName("multi_amount[]");
    var z = document.getElementsByName("multi_discount[]");
    var tot = 0;
    for(var i = 0 ; i < y.length ; i++){
      tot += (parseFloat(y[i].value) * parseFloat(x[i].value)) - parseFloat(z[i].value);
    }
    document.getElementById("total_before_tax").value = tot.toFixed(2);
  }

  function set_total_tax(){
    var y = document.getElementsByName("multi_tax_val[]");
    var tot = 0;
    for(var i = 0 ; i < y.length ; i++){
      tot += parseFloat(y[i].value);
    }
    document.getElementById("total_tax").value = tot.toFixed(2);
  }

  function set_final_total(){
    var y = document.getElementsByName("multi_total[]");
    var tot = 0;
    for(var i = 0 ; i < y.length ; i++){
      tot += parseFloat(y[i].value);
    }
    document.getElementById("final_total").value = tot.toFixed(2);
    set_remaining_amount();
  }

  function set_remaining_amount(){
    var x = document.getElementById("paid_amount").value - document.getElementById("final_total").value;
    document.getElementById("remaining_amount").value = x.toFixed(2);

    validate_bill_save();
  }

</script>

<!---------------------- validation --------------------------------------->
<script>
  function validate_bill_save(){
    if(bill_products_list.length >= 1 ){
      var x = bill_products_list.every(function(z){ return z == null});
      //console.log(x);
      if(!x){
        var cus = <?php echo $customers; ?>;
        var ids = document.getElementById("cus").value;
        var elementPos = cus.findIndex(x => x.id == ids);
        var objectFound = cus[elementPos];

        var BillTotal = parseFloat(document.getElementById("final_total").value);
        var paidAmount = parseFloat(document.getElementById("paid_amount").value);

        if(objectFound.type == 0){
          if(paidAmount >= BillTotal){
            document.getElementById("save_validate").disabled = false;
          }else{
            document.getElementById("save_validate").disabled = true;
          }

        }else{
          document.getElementById("save_validate").disabled = false;
        }
      }else{
        document.getElementById("save_validate").disabled = true
      }
    }else{
        document.getElementById("save_validate").disabled = true;
    }

  }
</script>
    @endsection

    