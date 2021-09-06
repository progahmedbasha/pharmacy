@extends('admin.layouts.header')

@section('content')



<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<style>
    .yt-list li{
        padding: 6px 0 ;
        cursor: pointer;
        font-weight: bold;
        padding-right: 12px ;


    }

    .yt-list li:hover {
        box-shadow: 0px 1px 4px #ddd;
        color: white;
        background-color: #420605;

    }
</style>
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
        <iframe src="{{url('printpurchasebill')}}/{{ Session::get('id') }}"></iframe>
      </div>
    </div>
  </div>
</div>
@endif

                  <input type="hidden" id="total_before_tax2" value="0">

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
        <option value="0" selected disabled>إختر المورد</option>
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
<br><!--<button type="button" name="add" id="add" class="btn btn-success add"><i class="fa fa-plus"></i></button>-->
<input type="text" class="form-control" id="barcodeScannerVal" onchange="barcode_scanner();"  oninput="this.onchange();" placeholder="Product Barcode" autofocus>
     <div class="w-100" id="DivId" >
         <ul class="list-unstyled yt-list" id="ListData">

         </ul>
     </div>
<br><br>
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
				<th>نوع الضريبة</th>
				<th>قيمة الضريبة</th>
				<th>الاجمالي</th>
        <th>ملاحظات</th>
				<th>حذف</th>
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
            <label for="pwd">خصم إضافى </label>
            <input type="number" step="0.001" class="form-control" id="bill_extra_discount" value="0" name="bill_extra_discount" onChange="set_final_total()" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();"  >
        </div>
    </div>

<div class="col-md-2">
    <div class="form-group">
      <label for="pwd">إجمالي الخصم</label>
      <input type="number" class="form-control" id="total_discount" value="0" name="total_discount" required readonly >
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
      <input type="number" step="0.001" class="form-control"  value="0" name="remaining_amount" id="remaining_amount">
    </div>
</div>


<div class="col-md-2">
    <div class="form-group">
      <label for="pwd">المخزن</label>
      <select class="form-control select2" name="store_id">
       <!-- <option disabled selected>إختر المخزن</option> -->
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
       <a href="{{url()->previous()}}" type="button" class="btn btn-danger" style="margin-top: 0px;">إلغاء</a>
    </div>
</div>

  </form>
</div>
</div>

</div>

</div>

<!---------------------- table --------------------------------------->

<script>

  var i = 0;
  var bill_products_list= new Array();

  function barcode_scanner(barCode) {
    var product_barcode = document.getElementById("barcodeScannerVal").value || barCode;

    if (product_barcode != '') {
        // GET every service Explanation section Details by serviceId
        $.ajax({
            url: "{{url('ajax_search_barcode_purchase')}}/"+ product_barcode,
            dataType: 'json',
            type: 'GET',
            cache: false,
            async: true,
            success: function (data) {
              if(!data.error){
                //console.log("success");
                //check_data(data.pro);
                set_product(data.pro);
              }
              else{
                //console.log(data);
                /*alert(data.message);
                document.getElementById("barcodeScannerVal").value = '';*/
              }
                $('#DivId').hide()
            },
            error: function (jqXhr, textStatus, errorThrown) {
                //console.log(errorThrown);
                //alert(errorThrown);
            }
        })

      }
  }
  $(document).on('click','.LiClick',function (){
      $('#barcodeScannerVal').val($(this).attr('attr_bar'))
      $('#barcodeScannerVal').focus()
      barcode_scanner($(this).attr('attr_bar'))
      $('#DivId').hide()

  });
  $(document).on('keyup','#barcodeScannerVal',function (){

      var product_name = $(this).val()
      $('#DivId').hide()

      $.ajax({
          url: "{{url('ajax_search_name')}}/"+ product_name,
          dataType: 'json',
          type: 'GET',
          cache: false,
          async: true,
          success: function (data) {
              console.log(data)
              if(!data.error){
                  console.log(data)
                  $('#ListData').html(data.html)
                  if (data.count > 0){
                      $('#DivId').show()
                  }
                  //console.log("success");
              }
              else{
                  if(data.status == 1){
                      $('#DivId').hide()
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


  });

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
      else
        set_product(data);
    }
  }

  function set_product(data){
    bill_products_list.push(data);
    if(data.item.isTax == 0)
    $isTaxview = '<td>غير خاضع</td>';
    else
    $isTaxview = '<td>خاضع</td>';

    $('.main').append
    ('<tr>'+
    '<td>'+ data.item.name_ar +'<input type="hidden" value="'+data.item.id+'" name="multi_product[]"> </td>'+

    '<td><input type="date" name="multi_production_date[]"class="form-control"/></td>'+

    '<td><input type="date" name="multi_expire_date[]"  class="form-control" required/></td>'+

    '<td><input type="number" step="0.001" value="'+data.item.default_sale_price+'"name="multi_price[]"  class="form-control" id="price'+i+'" onChange="price_tax('+i+')"  onpaste="this.onchange();" required/></td>'+

    '<td><input type="number" value="1"name="multi_amount[]"  class="form-control " value="0" id="quantity'+i+'" onChange="pro_total_pruce('+i+')" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();" required/></td>'+

    '<td><input type="number" step="0.001" name="multi_discount[]"  class="form-control DiscountAmount" value="0" id="discount'+i+'" onChange="pro_total_pruce('+i+')" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();" required/></td>'+

    $isTaxview+

    '<td><input type="number" step="0.001" name="multi_tax_val[]"  class="form-control" value="0" id="taxval'+i+'" readonly></td>'+

    '</td> <td><input type="text" name="multi_total[]" value="0" class="form-control" id="pro_total'+i+'" readonly/>'+

    '<td><input type="text" name="multi_note[]"  class="form-control"/></td>'+

    '<td><button type="button" class="btn btn-danger" onclick="deleteCurrentRow(this,'+i+')"><i class="fa fa-trash"></i></button></td>'+
    '</tr>');
    price_tax(i);
    ++i;
    document.getElementById("barcodeScannerVal").value = '';
    set_pro_count();
  }

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
      ty += parseInt(y[i].value);
    }
    document.getElementById("total_discount").value = ty + parseInt($('#total_discount').val());
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
      document.getElementById("total_before_tax2").value = tot.toFixed(2);

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


      var sum = 0;
      $('.DiscountAmount').each(function(){
          sum += parseFloat(this.value);
      });
      //
      //
      var op = parseInt($('#bill_extra_discount').val())
      //
      //
      $('#total_discount').val(sum + op ||0)

    var y = document.getElementsByName("multi_total[]");
    var tot = 0;

    for(var i = 0 ; i < y.length ; i++){
      tot += parseFloat(y[i].value);
    }

      $('#total_before_tax').val(parseInt($('#total_before_tax2').val()) - op)


      tot = tot - parseFloat(document.getElementById("bill_extra_discount").value);
    document.getElementById("final_total").value = tot.toFixed(2);
    set_remaining_amount();

  }

  function set_remaining_amount(){
    var x = parseFloat(document.getElementById("paid_amount").value) - parseFloat(document.getElementById("final_total").value);
    document.getElementById("remaining_amount").value = x.toFixed(2);

    validate_bill_save();
  }

</script>

<!---------------------- validation --------------------------------------->
<script>
  function validate_bill_save(){
    if(document.getElementById("supp").value > 0){
      if(bill_products_list.length >= 1 ){
        var x = bill_products_list.every(function(z){ return z == null});
        //console.log(x);
        if(!x){
          var supp = <?php echo $suppliers; ?>;
          var ids = document.getElementById("supp").value;
          var elementPos = supp.findIndex(x => x.id == ids);
          var objectFound = supp[elementPos];

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
            //console.log("c"+objectFound.type);
          }
        }else{
          document.getElementById("save_validate").disabled = true
        }
      }else{
          document.getElementById("save_validate").disabled = true;
          //console.log(bill_products_list.length);
      }
    }

  }
</script>
    @endsection

