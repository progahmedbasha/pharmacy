@extends('admin.layouts.header')

@section('content')

     
        <div class="analytics-sparkle-area">
            <div class="container-fluid">
			<br>
			المنتجات والخدمات: <a href="{{url('addproduct')}}" type="button" class="btn btn-info">اضافة صنف</a>

			<a href="{{url('barcodelist')}}/en" target="_blank" type="button" class="btn btn-success"><i class="fa fa-print" aria-hidden="true"></i> طباعة الباركود en</a>

			<a href="{{url('barcodelist')}}/ar" target="_blank" type="button" class="btn btn-success"><i class="fa fa-print" aria-hidden="true"></i> طباعة الباركود ar</a>
			<br><br>
			<div class="row">
			<div class="col-md-3">
			<b>اجمالي عدد المنتجات</b> <span style="color:green;font-size:16px;">{{$products->total()}}</span>
			</div>
			<div class="col-md-3">
			<b>اجمالي الكمية</b> <span style="color:green;font-size:16px;">{{$total_quantity}}</span>
			</div>
			<!--<div class="col-md-3">
			<b>متوسط تكلفة المنتجات</b> <span style="color:green;font-size:16px;">{{$total_avg_cost}}</span>
			</div>-->
      <div class="col-md-3">
      <b>إجمالي سعر البيع</b> <span style="color:green;font-size:16px;">{{round($total_sale_price,2)}}</span>
      </div>
			</div>
<br>
<div class="panel panel-default">
  <div class="panel-body">
  	<div class="row">
  	<div class="col-md-4">
      <form method="get" class="form-inline" action="{{url('productservice')}}/{{$paginationVal}}">
  	 <input class="form-control input-lg" name="search_val" type="text" required>
     <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i></button>
     <a href="{{url('productservice')}}/{{$paginationVal}}" class="btn btn-danger" style="margin-top:0px;"><i class="fa fa-times"></i></a>
   </form>
</div>

<div class="col-md-2">  
<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">عدد الصفوف : {{$paginationVal}}
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a  href="{{url('productservice')}}/10">10</a></li>
    <li><a  href="{{url('productservice')}}/25">25</a></li>
    <li><a  href="{{url('productservice')}}/50">50</a></li>
    <li><a  href="{{url('productservice')}}/100">100</a></li>
  </ul>
</div>
</div>
<div class="col-md-2">
<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">رقم الصفحة : {{$products->currentPage()}}
  <span class="caret"></span></button>
  <ul class="dropdown-menu" style="overflow-y: scroll;height:200px;">
  	@for($i=1; $i<=$products->lastPage();$i++)
    <li><a  href="{{url('productservice')}}/{{$paginationVal}}?page={{$i}}">{{$i}}</a></li>
    @endfor
  </ul>
</div>
</div>
</div>
<br>
<div class="table-responsive">
<table class="table table-bordered" >
    <thead>
      <tr>
        <th>#</th>
        <th>رقم الصنف </th>
		<th>اسم الصنف ar</th>
		<th>اسم الصنف en</th>
		<th>تاريخ الاضافة</th>
		<th>الكمية</th>
		<!--<th>التكلفة</th>-->
    <th>سعر البيع</th>
		<th style="width:180px;"">الاجراءات</th>
      </tr>
    </thead>
    <tbody id="myTable">
        @foreach($products as $index=>$product)
      <tr>
        <td>{{$index+1}}</td>
        <td>{{$product->code}}</td>
    		<td>{{$product->name_ar}}</td>
    		<td>{{$product->name_en}}</td>
        <td>{{$product->created_at}}</td>
    		@if(isset($product->product))
    			<td>{{$product->product->total_quantity}}</td>
    			<!--@if($product->product->total_quantity == 0)
    				<td>0</td>
    			@else
    				<td>{{round($product->product->total_cost/$product->product->total_quantity,2)}}</td> 
    			@endif-->
    		@else
    			<td>0</td>
    			<!-- <td>0</td>-->
    		@endif
        <td>{{$product->default_sale_price}}</td>
        <td>
        <a href="{{url('productdetail')}}/{{$product->id}}" class="btn btn-info" style="font-size:11px;">
            <i class="fa fa-eye" aria-hidden="true"></i></a>
            @if($product->type == 1 || $product->type == 2)
        		<a href="{{url('barcodesingle')}}/{{$product->id}}/en" class="btn btn-success" style="font-size:11px;">
            		<i class="fa fa-print" aria-hidden="true"></i> | en</a>

            	<a href="{{url('barcodesingle')}}/{{$product->id}}/ar" class="btn btn-success" style="font-size:11px;">
            		<i class="fa fa-print" aria-hidden="true"></i> | ar</a>
              
                <a target="_blank" href="{{url('Item_movement')}}/10/{{ $product->id}}" class="btn btn-primary"> حركة المنتج</a>
            @endif
            </td>
      </tr>
      @endforeach
    </tbody>
  </table>
   </div>
    </div>
    {{ $products->links() }}

	 </div>
            </div>
        </div>

<script>
/*$(document).ready(function() {
    $('#example').DataTable();
} );*/
</script>
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
    @endsection

    