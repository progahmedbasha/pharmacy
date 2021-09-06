<!DOCTYPE html>
<html lang="en">
<head>
  <title>Point of Sale</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="shortcut icon" type="image/x-icon" href="{{asset('img/icon.jpg')}}">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" >
  


	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />
  
 <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

<style>
body{
	background-color: #f8f9fa;
}

/*.dropbtn {
  background-color: #fff;
  color: black;
  padding: 8px;
  font-size: 14px;
  border: none;
  cursor: pointer;
}

.dropbtn:hover, .dropbtn:focus {
  background-color: #fff;
}

#myInput {
  box-sizing: border-box;
  background-image: url('img/searchicon.png');
  background-position: 14px 12px;
  background-repeat: no-repeat;
  font-size: 16px;
  padding: 14px 20px 12px 45px;
  border: none;
  border-bottom: 1px solid #ddd;
}

#myInput:focus {outline: 3px solid #ddd;}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f6f6f6;
  min-width: 230px;
  overflow: auto;
  border: 1px solid #ddd;
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown a:hover {background-color: #ddd;}

.show {display: block;}*/



.filterDiv {
  float: left;
  /*background-color: #2196F3;
  color: #ffffff;*/
  background-color: #e8e5e5;
    color: #880808;
    border-radius: 20px;
  text-align: center;
  margin: 2px;
  display: none;
  padding:20px;
  cursor: pointer;
}

.show {
  display: block;
}

.container {
  margin-top: 20px;
  overflow: hidden;
}


/* Style the buttons */
.btn1 {
  border: none;
  outline: none;
  padding: 12px 16px;
  background-color: #f1f1f1;
  cursor: pointer;
}

.btn1:hover {
  background-color: #ddd;
}

.btn1.active {
  background-color: #666;
  color: white;
}

ul, li {
  list-style: none;
  
}

th, td{
  font-size:10px;
}
</style>
</head>
<body> 

<div class="card" style=" height: 70px; ">
    <div class="card-body" style="background-color:brown;">
	<div class="row">

  
    <div class="col-lg-6">
        <div class="row justify-content-center gst20">

    <div class="col-sm-12">

<input type="text" id="querystr" name="querystr" class="form-control" onchange="showServiceData()" placeholder="Search Name" aria-describedby="basic-addon2">

 {{--     <form id="hdTutoForm" method="POST" action="">

        <div class="input-gpfrm input-gpfrm-lg">

            <input type="text" id="querystr" name="querystr" class="form-control" placeholder="Search Name" aria-describedby="basic-addon2">

        </div>

      </form>--}}

      <ul class="list-gpfrm" id="hdTuto_search"></ul>

    </div>

  </div>
      {{--
<div class="input-group mb-3">
    <input type="text" class="form-control" id="myInput2" onkeyup="myFunction2()" placeholder="Search..">
    <div class="input-group-append">
      <span class="input-group-text"><i class="fa fa-search" aria-hidden="true"></i></span>
    </div>
  </div>--}}
    </div>
  
  <div class="col-lg-6">
  <input type="text" class="form-control" id="barcodeScannerVal" onchange="barcode_scanner();" oninput="this.onchange();" placeholder="Product Barcode" autofocus>
   </div>

  </div>
  
 </div> 
  </div> 
  
<div class="container-fluid">
  <br>
  
<div class="row">

<div class="col-md-6 col-sm-12 col-xs-12">

{{--<div id="myBtnContainer">
<button class="btn active" onclick="filterSelection('all')"> Show all</button>
@foreach($categories as $index=>$value)
    <button class="btn1" onclick="filterSelection('{{$value->id}}')"> {{$value->category}}</button>
 @endforeach
</div>--}}

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
<hr>

<div class="container" id="myUL">

  @foreach($products as $index=>$value)
 <li><a><div style="width:24%;;height:120px;" class="filterDiv {{$index+1}}">

	<input type="hidden" id="pro{{$index}}" value="{{$value}}">
    <b class="card-text" style="font-size:11px;">{{$value->name}}</b>
	
  </div></a></li>
  @endforeach

</div>
</div> 


   <div class="col-md-6 col-sm-12 col-xs-12">
   <div style="padding:10px;background-color: #fff;">
   <form action="{{route('add_new_sale_bill')}}"  method="post">
    @csrf
    <input type="hidden" class="form-control" name="bill_source" value="0">
    <input type="hidden" class="form-control" name="bill_date" value="{{date('Y-m-d')}}">
    <input type="hidden" class="form-control" name="due_date" value="{{date('Y-m-d')}}">

  <div class="table-responsive">
   <table  class="table table-striped">
    <thead>
    <tr>
		<th>Product</th>
		<th>Price</th>
		<th>Quantity</th>
    <th>Discount</th>
		<th>SubTotal</th>
		<th>Taxes</th>
		<th>Total</th>
	</tr>
	 </thead>
	 <tbody id="add_to_me">
	 
	 </tbody>
   </table>
   </div>
   <hr>
   <hr>
   <table>
    <tr><td><b>Discount:</b></td><td><input type="text" id="total_discount" name="total_discount" style="width:40px;background:transparent;border:0px;" value="0" readonly>  SAR</td></tr>
   <tr><td><b>Sub total:</b></td><td><input type="text" id="total_before_tax" name="total_before_tax" style="width:40px;background:transparent;border:0px;" value="0" readonly>  SAR</td></tr>
   <tr><td><b>Taxes:</b></td><td><input type="text" id="total_tax" name="total_tax" style="width:40px;background:transparent;border:0px;" value="0" readonly>  SAR</td></tr>
   <tr><td colspan="2"><hr></td></tr>
   <tr><td><b>Total:</b></td><td><input type="text" id="final_total" name="final_total" style="width:40px;background:transparent;border:0px;" value="0" readonly>  SAR</td></tr>
   </table>
   <br><br>

   <div class="row">
   <div class="col-md-6">
   <div class="form-group">
   <label>المبلغ المدفوع</label>
    <input type="number" step="0.001" class="form-control" name="paid_amount" value="0" id="paid_amount" onChange="set_remaining_amount()" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();" required>
  </div>
</div>

   <div class="col-md-6">
   <div class="form-group">
   <label>المبلغ المتبقي</label>
    <input type="number" step="0.001" class="form-control" value="0" name="remaining_amount" id="remaining_amount" readonly>
  </div>
</div>
</div>

   <div class="row">
   <!--<div class="col-md-4">
   <div class="form-group">
   <label>Discount</label>
    <input type="number" class="form-control" id="usr" value="0" placeholder="Discount Value" >
	</div>
</div>-->
  <div class="col-md-6">
	<div class="form-group">
    <label for="pwd">العميل</label>
	  <select class="form-control select2" name="cus_id" id="cus">
		<!--<option data-tokens="Default Customer" selected disabled>Default Customer</option>-->
    @foreach($customers as $value)
		<option data-tokens="Customer2" value="{{$value->id}}">{{$value->name}}</option>
    @endforeach
	  </select>
	</div>
</div>
  <div class="col-md-6">
  <div class="form-group">
    <label for="pwd">طريقة الدفع</label>
    <select class="form-control" name="pay_way">
      <option value="0">كاش</option>
      <option value="1">شبكة</option>
  </select>
  </div>
</div>
</div>

<div class="row">
  <div class="col-md-6">
    <button type="submit" class="btn btn-success btn-lg btn-block" id="save_validate" disabled="disabled"><i class="fa fa-money" aria-hidden="true"></i> Pay Order</button>
  </div>

  <div class="col-md-6">
    <button type="button" class="btn btn-danger btn-lg btn-block" onclick='window.location.reload(true);'><i class="fa fa-trash" aria-hidden="true"></i> Cancel Order</button>
  </div>

</div>
  </form>  
   </div>
   </div>

</div>
  
</div>

<script> 	
  $(document).ready(function() {
    selectRefresh();
  });
   
  function selectRefresh() {
    $('.select2').select2({
      tags: true,
      placeholder: "Select an Option",
      allowClear: true,
      width: '100%'
    });
  }
</script> 

<script>
  function myFunction2() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("myInput2");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
  }

  filterSelection("all")
  function filterSelection(c) {
    var x, i;
    x = document.getElementsByClassName("filterDiv");
    if (c == "all") c = "";
    for (i = 0; i < x.length; i++) {
      w3RemoveClass(x[i], "show");
      if (x[i].className.indexOf(c) > -1) w3AddClass(x[i], "show");
    }
  }

  function w3AddClass(element, name) {
    var i, arr1, arr2;
    arr1 = element.className.split(" ");
    arr2 = name.split(" ");
    for (i = 0; i < arr2.length; i++) {
      if (arr1.indexOf(arr2[i]) == -1) {element.className += " " + arr2[i];}
    }
  }

  function w3RemoveClass(element, name) {
    var i, arr1, arr2;
    arr1 = element.className.split(" ");
    arr2 = name.split(" ");
    for (i = 0; i < arr2.length; i++) {
      while (arr1.indexOf(arr2[i]) > -1) {
        arr1.splice(arr1.indexOf(arr2[i]), 1);     
      }
    }
    element.className = arr1.join(" ");
  }

  // Add active class to the current button (highlight it)
  /*var btnContainer = document.getElementById("myBtnContainer");
  var btns = btnContainer.getElementsByClassName("btn");
  for (var i = 0; i < btns.length; i++) {
    btns[i].addEventListener("click", function(){
      var current = document.getElementsByClassName("active");
      current[0].className = current[0].className.replace(" active", "");
      this.className += " active";
    });
  }*/
</script>

<script type="text/javascript">
  var i = 0;
  var bill_products_list= new Array();

  function barcode_scanner() {
    var product_barcode = document.getElementById("barcodeScannerVal").value;

    if (product_barcode != '') {
        // GET every service Explanation section Details by serviceId
        $.ajax({
            url: "{{url('ajax_search_barcode')}}/"+ product_barcode,
            dataType: 'json',
            type: 'GET',
            cache: false,
            async: true,
            success: function (data) {
              if(!data.error){
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
      else
        set_product(data);
    }
  }

  function set_product(data){
    bill_products_list.push(data);

    $('#add_to_me').append
    ('<tr>'+
    '<td>'+ data.item.name_ar +'<input type="hidden" value="'+data.item.id+'" name="multi_product[]"></td>'+

    '<td><input type="text" value="'+data.item.default_sale_price+'" name="multi_price[]" id="price'+i+'" style="width:40px;background:transparent;border:0px;" readonly></td>'+

    '<td> <input type="number" value="1" onchange="pro_total_pruce('+i+')" oninput="this.onchange();" name="multi_amount[]" id="quantity'+i+'" style="width:40px;"></td>'+

    '<td><input type="text"  name="multi_discount[]" id="discount'+i+'" value="'+data.item.default_discount+'" style="width:40px;background:transparent;border:0px;" readonly></td>'+

    '<td><input type="text"  name="subTot[]" id="subTot'+i+'" value="'+data.item.default_sale_price+'" style="width:40px;background:transparent;border:0px;" readonly></td>'+

    '<td><input type="text" id="taxval'+i+'" name="multi_tax_val[]" style="width:40px;background:transparent;border:0px;" value="0" readonly></td>'+
    
    '<td><input type="text" id="pro_total'+i+'" name="multi_total[]" style="width:40px;background:transparent;border:0px;" value="0" readonly></td>'+
    
    '<td><button style="float:right;width: 25px; height: 25px; border-radius: 25px;font-size:12px;padding:4px;" type="button" class="btn btn-danger" onclick="deleteCurrentRow(this,'+i+')"><i class="fa fa-trash"></i></button></td>'+'</tr>'); 
    price_tax(i);
    ++i;
    document.getElementById("barcodeScannerVal").value = '';
  }

  function deleteCurrentRow(event,k){
    $(event).parents('tr').remove();
    //i--;
    //bill_products_list.splice(k, 1);
    bill_products_list[k]=null;
    
    /*console.log("len "+bill_products_list.length);
    console.log("i "+i);
    console.log("k "+k);
    console.log(bill_products_list);*/


    set_total_discount();
    set_total_before_tax();
    set_total_tax();
    set_final_total();
    set_remaining_amount();
    validate_bill_save();
    
  }
  
</script>

<script type="text/javascript">

  function calc_tax(val){
    tax = <?php echo $tax;?>;
    return (((tax.tax_value / 100) * val)/(1 + (tax.tax_value / 100))).toFixed(2);
  }
  
  function price_tax(k){
    var tax = <?php echo $tax;?>;
    if(tax.tax_type == 1 && bill_products_list[k].item.isTax == 1){
      var y = calc_tax(document.getElementById("price"+k).value);
      document.getElementById("price"+k).value = (document.getElementById("price"+k).value - y).toFixed(2);
      document.getElementById("taxval"+k).value = y;
    }
    pro_subtotal_price(k); 
    pro_total_pruce(k);
  }

  //-----------------------------------calculate subtotal with amount
  function pro_subtotal_price(k){
    var subtotal = (document.getElementById('quantity'+k).value * document.getElementById("price"+k).value) - document.getElementById('discount'+k).value ;
    document.getElementById('subTot'+k).value = subtotal;
  }

  function pro_total_pruce(k){
    if(parseInt(document.getElementById("quantity"+k).value) > bill_products_list[k].total_quantity)
      document.getElementById("quantity"+k).value = bill_products_list[k].total_quantity;
    get_tax_val(k);
    var x = parseFloat(document.getElementById("subTot"+k).value) ;
    var y = x + parseFloat(document.getElementById("taxval"+k).value);
    document.getElementById("pro_total"+k).value = y.toFixed(2);

    pro_subtotal_price(k);

    set_total_discount();
    set_total_before_tax();
    set_total_tax();
    set_final_total();
  }

  function get_tax_val(k){
    var tax = <?php echo $tax;?>;
    if(bill_products_list[k].item.isTax == 1){
      var y = parseFloat(document.getElementById("subTot"+k).value);
      var z = (tax.tax_value / 100) * y;
      document.getElementById("taxval"+k).value = z.toFixed(2);
    }
  }

</script>

<!----------------- Totals ------------------------>
<script type="text/javascript">
  
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

  function set_total_discount(){
    var y = document.getElementsByName("multi_discount[]");
    var ty = 0;
    for(var i = 0 ; i < y.length ; i++){
      ty += parseInt(y[i].value);
    }
    document.getElementById("total_discount").value = ty;
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
    //document.getElementById("paid_amount").value = tot.toFixed(2);
    
    set_remaining_amount();
  }

  function set_remaining_amount(){
    var x = document.getElementById("paid_amount").value - document.getElementById("final_total").value;
    document.getElementById("remaining_amount").value = x.toFixed(2);

    validate_bill_save();
  }
</script>


<script type="text/javascript">

  function validate_bill_save(){
    if(bill_products_list.length >= 1 ){
      var x = bill_products_list.every(function(z){ return z == null});
      //console.log(x);
      if(!x){
        var BillTotal = parseFloat(document.getElementById("final_total").value);
        var paidAmount = parseFloat(document.getElementById("paid_amount").value);
        if(paidAmount >= BillTotal){
          document.getElementById("save_validate").disabled = false;
        }else{
          document.getElementById("save_validate").disabled = true;
        }
      }else{
        document.getElementById("save_validate").disabled = true
      }
    }else{
      document.getElementById("save_validate").disabled = true;
    }
  }

</script>


</body>
</html>
