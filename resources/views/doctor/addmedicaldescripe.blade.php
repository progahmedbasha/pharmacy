@extends('doctor.layouts.header')

@section('content')

<style>

#country-list{float:left;list-style:none;margin-top:-3px;padding:0;width:190px;position: absolute;z-index: 1111;}
#country-list li{padding: 10px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid;}
#country-list li:hover{background:#ece3d2;cursor: pointer;}
#search-box{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}
</style>
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />


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
  <div class="panel-heading">اضافة وصفة طبية</div>
  <div class="panel-body">
<form action="{{route('add_new_prescription')}}"  method="post">
@csrf
<div class="row">

  <div class="col-sm-12">
<div class="form-group">
<label for="email">نوع المريض</label>
<div class="radio">
  <label><input type="radio" name="patient_type" value="1" onclick="current_patient_part()" checked>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;مريض موجود</label>
  <label><input type="radio" name="patient_type" value="2" id="default_val_check" onclick="new_patient_part()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;مريض جديد</label>
  

</div>

</div>
</div>

<div id="current_patient">
<div class="col-sm-4">
    <div class="form-group">
       <label for="email">رقم الملف</label>
       <select class="form-control selectpicker"  data-live-search="true" name="patient_id" >
        @foreach($patients as $index=>$value)
        <option value="{{$value->id}}">{{$value->folder_number}}-{{$value->patient_name}}</option>
        @endforeach
       </select>
    </div>
</div> 
</div>

<div id="old_patient" style="display:none;">

<div class="col-md-4">
    <div class="form-group">
      <label for="email">رقم الملف</label><br>
       <input type="text" class="form-control" required  name="patient_file_no" id="patient_file_no">
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">اسم المريض</label><br>
       <input type="text" class="form-control" required  name="patient_name" id="patient_name">
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">رقم الهاتف</label><br>
       <input type="text" class="form-control" required  name="patient_phone" id="patient_phone">
    </div>
</div>
</div>

</div>


<div class="row">
 <div class="col-sm-12">
<br><!--<button type="button" name="add" id="add" class="btn btn-success add"><i class="fa fa-plus"></i></button><br><br>-->
  <!--<input type="text" class="form-control" id="barcodeScannerVal" onchange="barcode_scanner();"  oninput="this.onchange();" placeholder="بحث باسم المنتج" autofocus>-->

  <div class="frmSearch">
<input type="text" id="search-box" placeholder="بحث بالاسم" />
<div id="suggesstion-box" >
</div>  
</div>

   <br><br>
<div class="table-responsive">
        <table class="table table-bordered table-striped main" id="dynamicTable">  
            <tr>
                <th style="width:220px;">اســـم المنتـــج</th>
                <th style="width:120px;">الكمية الفعلية</th>
                <th style="width:120px;">الكمية المطلوبة</th>
                <th>ملاحظات</th>

              <th>حذف</th>
            </tr>
           <!-- <tr>
                <th >-</th>
                <th>-</th>
                <th>-</th>
                <th>-</th>

              <th>-</th>
            </tr>-->
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

<script type="text/javascript">
  function new_patient_part(){
    document.getElementById("old_patient").style.display = "block";
    document.getElementById("current_patient").style.display = "none";
  }

  function current_patient_part(){
    document.getElementById("old_patient").style.display = "none";
    document.getElementById("current_patient").style.display = "block";
  }
</script>


<script type="text/javascript">

  var pp = null;
  var i = 0;
  var bill_products_list= new Array();
  $(document).ready(function(){
    $("#search-box").keyup(function(){
      $.ajax({
        type: 'GET',
        url:  "{{url('productsearch')}}/"+ $(this).val(),
        //data:'search_val='+$(this).val(),
        dataType: 'json',
        cache: false,
        async: true,
       /* beforeSend: function(){
          $("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
        },*/
        success: function(data){
          $("#suggesstion-box").show();
          $("#suggesstion-box").html(data);
          $("#search-box").css("background","#FFF");
          if(!data.error){
            // console.log(data.pro);
             set_product(data.pro);
          }else{}
         
        },
        error: function (jqXhr, textStatus, errorThrown) {
          console.log(errorThrown);
          //alert(errorThrown);
        }
      });
    });

    selectRefresh();
  });

</script>

<script type="text/javascript">

  function set_product(pro){
    pp = pro;
    $('#suggesstion-box').append('<ul style="height: auto;max-height:250px; overflow-y: scroll;" id="country-list">');
    for(var i = 0 ; i < pro.length ;i++ ) {
      //var json_pro = JSON.stringify(pro[i].product);
      //console.log(json_pro);
      $('#country-list').append('<li onClick="select_product('+i+')">' + pro[i].name_en + '</li>');
    }
    $('#suggesstion-box').append('</ul>');
  }

  function select_product(i){
    //JSON.parse(product);
    var product = pp[i];
    //console.log(pp[i]);
    $("#search-box").val('');
    $("#suggesstion-box").hide();
    check_data(product); 
  }

  function check_data(data){
    if(bill_products_list.length == 0){
      set_product_table(data);
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
        set_quantity(x);
      }
      else{
        set_product_table(data);
      }
    }
  }
</script>

<script type="text/javascript">

  function set_product_table(product){
    bill_products_list.push(product);
    var qua = 0;
    if(product.product.total_quantity > 0)
      qua = 1;
    $('.main').append
      ('<tr>'+
      '<td>'+ product.name_en +'<input type="hidden" value="'+product.id+'" name="multi_product[]"> </td>'+

      '<td>'+product.product.total_quantity+'</td>'+

      '<td><input type="number" value="'+qua+'" min="1" name="multi_amount[]" class="form-control" required onchange="set_quantity('+i+')" id="quantity'+i+'"/></td>'+

      '<td><textarea rows="1" name="multi_notes[]" class="form-control"/></textarea></td>'+

      '<td><button type="button" class="btn btn-danger" onclick="deleteCurrentRow(this,'+i+')"><i class="fa fa-trash"></i></button></td>'+
      '</tr>'); 
      i++;

      validate_bill_save();
      set_pro_count();
  }

  function set_quantity(k){
    if(parseInt(document.getElementById("quantity"+k).value) > bill_products_list[k].product.total_quantity)
      document.getElementById("quantity"+k).value = bill_products_list[k].product.total_quantity;
  }

  function deleteCurrentRow(event,k){
    $(event).parents('tr').remove();
    bill_products_list[k]=null;

    set_pro_count();
    validate_bill_save();
  }

  function set_pro_count(){
    var x = document.getElementsByName("multi_product[]").length;
    document.getElementById("pro_count").value = x;
  }

  function validate_bill_save(){
    if(bill_products_list.length >= 1 ){
      var x = bill_products_list.every(function(z){ return z == null});
       if(x)
          document.getElementById("save_validate").disabled = true;
       else
          document.getElementById("save_validate").disabled = false;
  
    }else{
      document.getElementById("save_validate").disabled = true;
      console.log(2);
    }
  }
</script>


    @endsection

    