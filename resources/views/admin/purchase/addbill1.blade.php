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

			<br>

<div class="panel panel-default">
  <div class="panel-heading">اضافة فاتورة</div>
  <div class="panel-body">
<form action="{{route('add_new_purch_bill')}}"  method="post">
@csrf
<div class="row">

<div class="col-md-4">
    <div class="form-group">
      <label for="email">اختر المورد</label><br>
      <select class="form-control select2"  name="supp_id" id="supp" onChange="get_supp_val()">
        <option >إختر المورد</option>
        @foreach($suppliers as $value)
        <option value="{{$value->id}}">{{$value->name}} {{$value->tree->id_code}}</option>
        @endforeach
    </select>
    </div>
</div>

<div class="col-md-2">
    <div class="form-group">
      <label for="pwd">رصيد المورد</label>
      <input type="text" class="form-control" id="supp_balance" disabled>
    </div>
</div>

<div class="col-md-2">
  <div class="form-group">
    <label for="email">نوع الفاتورة</label>
      <input type="text"  class="form-control" id="supp_type" disabled>
  </div>
</div>

<div class="col-md-2">
    <div class="form-group">
      <label for="pwd">تاريخ الفاتورة</label>
      <input type="date" class="form-control" name="bill_date" value="{{date('Y-m-d')}}" required>
    </div>
</div>

<div class="col-md-2">
    <div class="form-group">
      <label for="pwd">مندوب المشتريات</label>
     <select class="form-control select2"  data-live-search="true" name="employee_id">
        <option disabled selected>إختر مندوب</option>
        @foreach($employees as $value)
          <option value="{{$value->id}}">{{$value->name}}</option>
        @endforeach
    </select>
    </div>
</div>


</div>


<div class="row">
 <div class="col-sm-12">
<br><button type="button" name="add" id="add" class="btn btn-success add"><i class="fa fa-plus"></i></button><br><br>
<div class="table-responsive">
        <table class="table table-bordered table-striped main" id="dynamicTable">  
            <tr>
                <th style="width:150px;">اســـم المنتـــج</th>
                <th style="width:50px;">تاريخ الإنتاج</th>
                <th style="width:50px;">تاريخ الإنتهاء</th>
                <th>السعر</th>
                <!--<th>الوحدة</th>-->
				<th>الكمية</th>
                <th>الخصم</th>
				<th style="width:100px;">نوع الضريبة</th>
				<th>قيمة الضريبة</th>
				<th>الاجمالي</th>
        <th>ملاحظات</th>
				<th>حذف</th>
            </tr>
            <tr>  
                <td>
                 <select name="multi_product[]" id="pro0" class="form-control select2" onChange="get_pro(0)">
                  <option >إختر المنتج</option>
                  @foreach($products as $value)
                    <option value="{{$value->id}}">{{$value->name}}</option>
                  @endforeach
                  </select>
                </td> 
                <td><input type="date" name="multi_production_date[]"  class="form-control"/></td>
                <td><input type="date" name="multi_expire_date[]"  class="form-control"/></td>
                <td><input type="number" step="0.001" name="multi_price[]"  class="form-control" id="price0" onChange="price_tax(0)"  onpaste="this.onchange();"/></td>  
                <!--<td><input type="text" name="multi_unit[]"  class="form-control" /></td> --> 
				 <td><input type="number" name="multi_amount[]"  class="form-control" value="0" id="quantity0" onChange="pro_total_pruce(0)" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();"/></td>  
                <td><input type="number" name="multi_discount[]"  class="form-control" value="0" id="discount0" onChange="pro_total_pruce(0)" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();"/></td> 
				<td><input type="text"  name="multi_istax[]" class="form-control" id="isTax0" disabled></td> 
				<td><input type="number" step="0.001" name="multi_tax_val[]"  class="form-control" value="0" id="taxval0" readonly></td> 
				<td><input type="number" step="0.001" name="multi_total[]"  class="form-control" id="pro_total0" readonly/></td>
        <td><input type="text" name="multi_note[]"  class="form-control"/></td> 
                <td><!--<button type="button" class="btn btn-danger remove-tr"><i class="fa fa-trash"></i></button>--></td>  
            </tr>  
        </table> 
		</div>
</div>
</div>


<div class="row">
<div class="col-md-2">
    <div class="form-group">
      <label for="email">إجمالي الاصناف</label>
      <input type="number" class="form-control" name="pro_count" value="1" id="pro_count" required readonly>
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
      <input type="number" class="form-control" name="paid_amount" value="0" id="paid_amount" onChange="set_remaining_amount()" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();" required>
    </div>
</div>
</div>

<div class="row">
<div class="col-md-2">
    <div class="form-group">
      <label for="pwd">المبلغ المتبقي</label>
      <input type="number" step="0.001" class="form-control"  value="0" name="remaining_amount" id="remaining_amount">
    </div>
</div>


<div class="col-md-2">
    <div class="form-group">
      <label for="pwd">المخزن</label>
      <select class="form-control select2" name="store_id">
        <option disabled selected>إختر المخزن</option>
        @foreach($stores as $value)
        <option value="{{$value->id}}">{{$value->store_name}}</option>
        @endforeach
    </select>
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
   <div class="col-md-12">
      <button type="submit" class="btn btn-primary" id="save_validate" disabled="disabled">حفظ</button>
    </div>
</div>

  </form>
</div>
</div>


</div>



</div>

<!---------------------- table --------------------------------------->

<script>

  function selectRefresh() {
    $('.select2').select2({
      tags: true,
      placeholder: "Select an Option",
      allowClear: true,
      width: '100%'
    });
  }

     var i = 0;

  $('.add').click(function() {

    ++i;

    $('.main').append('<tr><td><select name="multi_product[]"  id="pro'+i+'" class="form-control select2" onChange="get_pro('+i+')"> <option >إختر المنتج</option><?php foreach($products as $value) { ?> <option value="{{$value->id}}">{{$value->name}}</option> <?php } ?> </select></td><td><input type="date" name="multi_production_date[]"  class="form-control"/></td><td><input type="date" name="multi_expire_date[]"  class="form-control"/></td><td><input type="number" step="0.001" name="multi_price[]"  class="form-control" id="price'+i+'" onChange="price_tax('+i+')"  onpaste="this.onchange();"/></td> <!--<td><input type="text" name="multi_unit[]"  class="form-control" /></td> --> <td><input type="number" name="multi_amount[]"  class="form-control" value="0" id="quantity'+i+'" onChange="pro_total_pruce('+i+')" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();"/></td> <td><input type="number" name="multi_discount[]"  class="form-control" value="0" id="discount'+i+'" onChange="pro_total_pruce('+i+')" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();"/></td> <td><input type="text"  name="multi_istax[]" class="form-control" id="isTax'+i+'" disabled></td> <td><input type="number" step="0.001" name="multi_tax_val[]"  class="form-control" value="0" id="taxval'+i+'" readonly></td> <td><input type="number" step="0.001" name="multi_total[]"  class="form-control" id="pro_total'+i+'" readonly/></td><td><input type="text" name="multi_note[]"  class="form-control"/></td><td><button type="button" class="btn btn-danger remove-tr"><i class="fa fa-trash"></i></button></td></tr>');
    selectRefresh();
    set_pro_count();
  });


  $(document).ready(function() {
    selectRefresh();
  });

  //$('.my-select').select2();

  $(document).on('click', '.remove-tr', function(){  
    $(this).parents('tr').remove();
    set_total_discount();
    set_total_before_tax();
    set_total_tax();
    set_final_total();
  }); 

</script>

<!---------------------- product --------------------------------------->

<script>
  var tax , product ,elementPos , objectFound;

  function info(k){
    tax = <?php echo $tax;?>;
    product = <?php echo $products;?>;
    var ids = document.getElementById("pro"+k).value;
    elementPos = product.findIndex(x => x.id == ids);
    objectFound = product[elementPos];
  }

  function get_pro(k) {
    info(k); 
    document.getElementById("price"+k).value = objectFound.product.default_buy_price;

    if(objectFound.isTax == 1){
      document.getElementById("isTax"+k).value = 'خاضع';
    }else{
      document.getElementById("isTax"+k).value = 'غير خاضع';
    }
    price_tax(k);
  }

  function price_tax(k){
    info(k);
    if(tax.tax_type == 1 && objectFound.isTax == 1){
      var y = calc_tax(document.getElementById("price"+k).value);
      document.getElementById("price"+k).value = (document.getElementById("price"+k).value - y).toFixed(2);
    }
    pro_total_pruce(k);
  }

  function pro_total_pruce(k){
    get_tax_val(k);
    var x = ((document.getElementById("price"+k).value * document.getElementById("quantity"+k).value) - document.getElementById("discount"+k).value);
    //console.log(document.getElementById("taxval"+k).value);
    var y = x + parseFloat(document.getElementById("taxval"+k).value);
    document.getElementById("pro_total"+k).value = y.toFixed(2);

    set_total_discount();
    set_total_before_tax();
    set_total_tax();
    set_final_total();

    //validate_bill_save();
  }

  function get_tax_val(k){
    info(k);
    if(objectFound.isTax == 1){
      var y = (document.getElementById("price"+k).value * document.getElementById("quantity"+k).value) - document.getElementById("discount"+k).value;
      var z = (tax.tax_value / 100) * y;
      document.getElementById("taxval"+k).value = z.toFixed(2);
    }
  }

  function calc_tax(val){
    tax = <?php echo $tax;?>;
    return (((tax.tax_value / 100) * val)/(1 + (tax.tax_value / 100))).toFixed(2);
  }
  
  function get_supp_val(){
    var supp = <?php echo $suppliers; ?>

    var ids = document.getElementById("supp").value;

    var elementPos = supp.findIndex(x => x.id == ids);
    var objectFound = supp[elementPos];

    document.getElementById("supp_balance").value = objectFound.tree.balance;
    if(objectFound.type == 0)
      document.getElementById("supp_type").value = "نقدي";
    else
      document.getElementById("supp_type").value = "آجل";

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
      ty += parseFloat(y[i].value);
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
    document.getElementById("total_before_tax").value = tot;
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
  var supp = <?php echo $suppliers; ?>;
  var ids = document.getElementById("supp").value;
  var elementPos = supp.findIndex(x => x.id == ids);
  var objectFound = supp[elementPos];

  var BillTotal      = document.getElementById("final_total").value;
  var paidAmount     = document.getElementById("paid_amount").value;
  var CurrentBalance = objectFound.tree.balance * -1;
  //console.log(BillTotal);
  //console.log(paidAmount);
  //console.log(CurrentBalance);
  var t = parseFloat(CurrentBalance)+ parseFloat(paidAmount);
  //console.log(t);

  if(objectFound.type == 0){
    if(paidAmount >= BillTotal){
      document.getElementById("save_validate").disabled = false;
    }else if(t < BillTotal ){
    document.getElementById("save_validate").disabled = true;
    }else{
      document.getElementById("save_validate").disabled = false;
    }

  }else{
    document.getElementById("save_validate").disabled = false;
  }

}
</script>
    @endsection

    