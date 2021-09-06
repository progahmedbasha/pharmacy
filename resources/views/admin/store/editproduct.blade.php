@extends('admin.layouts.header')

@section('content')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />


<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

<style>
#multi_values{
	display:none;
}

/*.select2-container .select2-selection--single{
    height:34px !important;
	width:100%;
}
.select2-container--default .select2-selection--single{
         border: 1px solid #ccc !important; 
     border-radius: 0px !important; 
}*/
.select2-container .select2-selection--single {

height:40px;
  }
</style>

     <br><br>
        <div class="analytics-sparkle-area">
            <div class="container-fluid">
			<br>
			<div class="panel panel-default">
        <div class="panel-heading">تعديل الصنف</div>
        
		
		    

<br><br>
  <div class="panel-body">
			
<form action="{{route('edit_product')}}" method="post">
@csrf

<input type="hidden" class="form-control"  name="item_id" value="{{ $item->id }}" required>
@if($item->product != null)
  <input type="hidden" class="form-control"  name="product_id" value="{{ $item->product->id }}" required>
@endif

 <div class="row">
  
 <div class="col-sm-4">
    <div class="form-group">
      <label for="email"> اسم الصنف (en)</label>
      <input type="text" class="form-control"  name="item_name_en" value="{{ $item->name_en }}" required>
    
	 @error('item_name_en')
    <div class="alert alert-danger">{{ $message }}</div>
   @enderror
	</div>
  </div>
  
   <div class="col-sm-4">
    <div class="form-group">
      <label for="email"> اسم الصنف (ar)</label>
      <input type="text" class="form-control"  name="item_name_ar" value="{{$item->name_ar}}" required>
    
		   @error('item_name_ar')
    <div class="alert alert-danger">{{ $message }}</div>
   @enderror
	</div>
  </div>

@if($item->product != null)
  <div class="col-sm-4">
  <div class="form-group">
     <label for="email">الباركود</label>
        <input type="text" class="form-control" name="barcode" value="{{ $item->product->barcode }}" disabled>
       @error('barcode')
      <div class="alert alert-danger">{{ $message }}</div>
     @enderror
      </div>
  </div>
@endif
<div class="col-sm-4">
<div class="form-group">
  <label for="email">نوع الضريبة </label>
    <div class="form-control">
      <label><input type="radio" name="tax_type" value="0" {{ ($item->isTax == 0) ? 'checked' : '' }}>&nbsp;&nbsp;&nbsp;غير خاضع</label>&nbsp;&nbsp;
  <label><input type="radio" name="tax_type" value="1"  {{ ($item->isTax == 1) ? 'checked' : '' }}>&nbsp;&nbsp;&nbsp;خاضع</label>&nbsp;&nbsp;&nbsp;
</div>
</div>
</div>

<div class="col-sm-4">
    <div class="form-group">
      <label for="email">سعر البيع الافتراضى</label>
      <input type="number" step="0.0001" class="form-control" name="defaultprice_sale" value="{{ $item->default_sale_price }}" required>
    
	   @error('defaultprice_sale')
    <div class="alert alert-danger">{{ $message }}</div>
   @enderror
	</div>
</div>

<div class="col-sm-4">
    <div class="form-group">
      <label for="email">الخصم الافتراضى</label>
      <input type="number" step="0.0001" class="form-control" name="default_discount" value="{{ $item->default_discount }}" required>
    
     @error('defaultprice_sale')
    <div class="alert alert-danger">{{ $message }}</div>
   @enderror
  </div>
</div>

<!--

<div class="col-sm-4">
    <div class="form-group">
       <label for="email">التصنيف الرئيسى</label>
       <select class="form-control selectpicker"  data-live-search="true" name="main_category" id="main_category" onChange="main_category_val()">
        <option value="-1" disabled selected>اختر الفئة الرئيسية</option>
        @foreach($categories as $index=>$value)
        <option value="{{$value->sup_category}}">{{$value->category}}</option>
        @endforeach
       </select>
       @if($errors->any())
    <div class="alert alert-danger">برجاء إختيار التصنيف الرئيسي</div>
   @endif
    </div>
  </div>  


<div class="col-sm-4">
<div class="form-group">
  <label for="email">التصنيف الفرعى</label>
   <select class="form-control"  name="sub_category" id="subcat">
       </select>
       @if($errors->any())
    <div class="alert alert-danger">برجاء إختيار التصنيف الفرعي</div>
   @endif
   </div>
 </div>
-->
<script>
  function main_category_val() {

    var d = JSON.parse(document.getElementById("main_category").value);
    //document.getElementById("lis_val").value = d;
    
    //console.log(d);

    var catOptions = "";
    catOptions += "<option value='' disabled selected=''>إختر الفئة الفرعية</option>";
     if (d.length == 0) {
      //document.getElementById("subcat").innerHTML = "<option></option>";
      }else {
		   var locale = '{{ config('app.locale') }}';
		   if(locale == 'ar')
        var name = d.map(({category_ar}) => category_ar);
		else
		var name = d.map(({category_en}) => category_en);
		
        var id = d.map(({id}) => id);
        for (x in name) {
          catOptions += "<option value ='" + id[x] +"'>" + name[x] + "</option>";
        }
       // console.log("ddd",d);
      }
      document.getElementById("subcat").innerHTML = catOptions;
  }
</script>


<!---------------------------------------------------->
<div id="item_more">
<!--
<div class="col-sm-4">
<div class="form-group">
   <label for="email">المخزون الافتتاحى</label>
      <input type="number" class="form-control" name="base_amount" value="{{ old('base_amount') }}" >
	  
	   @error('base_amount')
    <div class="alert alert-danger">{{ $message }}</div>
   @enderror
    </div>
  </div> 
-->
@if($item->product != null)
<div class="col-sm-4">
<div class="form-group">
  <label for="email">المادة الفعالة (en)</label>
      <input type="text" class="form-control" name="react_material_en" value="{{ $item->product->react_material_en }}">
    @error('react_material_en')
    <div class="alert alert-danger">{{ $message }}</div>
   @enderror
	
	</div>
</div>


<div class="col-sm-4">
<div class="form-group">
  <label for="email">المادة الفعالة (ar)</label>
      <input type="text" class="form-control" name="react_material_ar" value="{{ $item->product->react_material_ar }}">
    
	@error('react_material_ar')
    <div class="alert alert-danger">{{ $message }}</div>
   @enderror
	</div>
</div>


<div class="col-sm-4">
    <div class="form-group">
      <label for="email">المخزن الافتراضى</label>
      <select class="form-control selectpicker" name="base_store" data-live-search="true">
        @foreach($main_stores as $value)
        <option value="{{$value->id}}" {{ ($item->product->store_id == $value->id) ? 'selected' : '' }}>{{$value->store_name}}</option>
        @endforeach
       </select>
    </div>
</div>




<div class="col-sm-4">
<div class="form-group">
   <label for="email">حد تنيه انتهاء المخزون</label>
      <input type="number" class="form-control" name="stock_limit_alarm" value="{{ $item->product->stock_limit }}">
    
	@error('stock_limit_alarm')
    <div class="alert alert-danger">{{ $message }}</div>
   @enderror
	</div>
</div>


<div class="col-sm-4">
<div class="form-group">
   <label for="email">التركيز</label>
      <input type="number" step="0.001" class="form-control @error('concentrate') is-invalid @enderror" name="concentrate" value="{{ $item->product->concentrate }}">
     @error('concentrate')
    <div class="alert alert-danger">{{ $message }}</div>
   @enderror
	
	</div>
	   
</div>


 <div class="col-sm-4">
    <div class="form-group">
       <label for="email">سعر الشراء الافتراضى</label>
      <input type="number" step="0.0001" class="form-control" name="defaultprice_purchase" value="{{ $item->product->default_buy_price }}">
    @error('defaultprice_purchase')
     <div class="alert alert-danger">{{ $message }}</div>
   @enderror
	</div>
</div>




<div class="col-sm-4">
<div class="form-group">
   <label for="email">sku رمز المصنع </label>
      <input type="text" class="form-control" name="sku_code" value="{{ $item->product->SKU_code }}">
	   @error('sku_code')
    <div class="alert alert-danger">{{ $message }}</div>
   @enderror
    </div>
</div>

<div class="col-sm-4">
<div class="form-group">
  <label for="email">نوع المنتج</label>
      <select class="form-control"  name="pro_type">
        @foreach($pro_types as $value)
          <option value="{{$value->id}}" {{ ($item->product->product_type_id  == $value->id) ? 'selected' : '' }}>{{$value->type}}</option>
        @endforeach
      </select>
    </div>
</div>

<div class="col-sm-4">
<div class="form-group">
  <label for="email">نوع تتبع  المخزون</label><br>
  <input type="radio"  name="stock_tracking" value="0"  {{ ($item->product->track_type == 0) ? 'checked' : '' }}>&nbsp;&nbsp;&nbsp;التاريخ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <input type="radio"  name="stock_tracking" value="1" {{ ($item->product->track_type == 1) ? 'checked' : '' }}>&nbsp;&nbsp;&nbsp;الكمية
@error('stock_tracking')
    <div class="alert alert-danger">{{ $message }}</div>
   @enderror
</div>
</div>

@endif



</div>


</div>



<div class="col-sm-12">
<button type="submit" class="btn btn-primary">تعديل</button>

</div>

</form>



</div>
</div>

</div>
</div>
<br><br>
</div>


            </div>
        </div>
		

@if(old('active_multi_val') == 1)
<script>
 document.getElementById("multi_values").style.display = "block";
document.getElementById("if_multi_date").style.display = "none";
</script>
@endif
		
		
@if(old('item_type') == 3)
<script>
document.getElementById("item_more").style.display = "none";
document.getElementById("multi_values").style.display = "none";
document.getElementById("active_multi_val").checked = false;
</script>

@endif

<script>

//$('.my-select').selectpicker();

    function service_fields_disable(){
document.getElementById("item_more").style.display = "block";
document.getElementById("if_multi_date").style.display = "block";
}

function service_fields_enable(){
document.getElementById("item_more").style.display = "none";
document.getElementById("multi_values").style.display = "none";
document.getElementById("active_multi_val").checked = false;
}

function enable_disable_multival(){
 // Get the checkbox
  var checkBox = document.getElementById("active_multi_val");

  // If the checkbox is checked, display the output text
  if (checkBox.checked == true){
   document.getElementById("multi_values").style.display = "block";
   document.getElementById("if_multi_date").style.display = "none";
  } else {
    document.getElementById("multi_values").style.display = "none";
	document.getElementById("if_multi_date").style.display = "block";
  }
}



</script>

<script type="text/javascript">
          
    $(".add").click(function(){
      
	$(".main").append('<tr> <td> <select name="multi_store[]"  class="form-control select2"> <option value="-1" disabled selected>اختر المخزن</option><?php foreach($stores as $value){ ?> <option value="{{$value->id}}">{{$value->store_name}}</option><?php } ?> </select> </td> <td><input type="number" name="multi_amount[]"  class="form-control" /></td> <td><input type="number" step="0.0001" name="multi_price[]"  class="form-control" /></td> <td><input type="date" name="multi_production_date[]"  class="form-control" /></td> <td><input type="date" name="multi_expire_date[]"  class="form-control" /></td> <td><input type="text" name="multi_notes[]"  class="form-control" /></td> <td><button type="button" class="btn btn-danger remove-tr"><i class="fa fa-trash"></i></button></td> </tr>');
  /*$('.my-select').selectpicker();
		$('.my-select').selectpicker('refresh');
	});*/
   
    $(document).on('click', '.remove-tr', function(){  
         $(this).parents('tr').remove();

         
    });  
   
   /*
     $(function() {
  $('.selectpicker').selectpicker();*/
  selectRefresh();
});

</script>


<script type="text/javascript">
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
	
