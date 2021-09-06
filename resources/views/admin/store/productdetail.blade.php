@extends('admin.layouts.header')

@section('content')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<style>
#multi_values{
	display:none;
}
.breadcome-list {
    margin-top: 50px;
}
</style>


     
        <div class="analytics-sparkle-area">
            <div class="container-fluid">
			<br><br><br>
			<a href="{{url('editproduct')}}/{{$product->id}}" class="btn btn-info">
            <i class="fa fa-edit" aria-hidden="true"></i> تعديل بيانات</a>
      <a href="{{url()->previous()}}" type="button" class="btn btn-info">رجوع</a>
			<br><br>
			<div class="panel panel-default">
			 <div class="panel-heading">تفاصيل الصنف</div>
  <div class="panel-body">
			


 <div class="row">
  
   <div class="col-sm-4">
<div class="form-group">
<label for="email">النوع</label>
  @if($product->type == 1)
   <input type="text" class="form-control"  value="منتج" disabled>
   @elseif($product->type == 2)
   <input type="text" class="form-control"  value="خامة" disabled>
   @elseif($product->type == 3)
   <input type="text" class="form-control"  value="خدمة" disabled>
   @endif

</div>
</div>


 <div class="col-sm-4">
    <div class="form-group">
      <label for="email">كود الصنف</label>
      <input type="text" class="form-control"  value="{{$product->code}}" disabled>
    </div>
  </div>

  <div class="col-sm-4">
    <div class="form-group">
      <label for="email">الباركود</label>
      <input type="text" class="form-control"  value="{{$product->product->barcode}}" disabled>
    </div>
  </div>
 
 <div class="col-sm-4">
    <div class="form-group">
      <label for="email"> اسم الصنف (en)</label>
      <input type="text" class="form-control"  value="{{$product->name_en}}" disabled>
    </div>
  </div>
  
  <div class="col-sm-4">
    <div class="form-group">
      <label for="email"> اسم الصنف (ar)</label>
      <input type="text" class="form-control"  value="{{$product->name_ar}}" disabled>
    </div>
  </div>

<div class="col-sm-4">
<div class="form-group">
  <label for="email">نوع الضريبة </label>
  @if($product->isTax == 0)
 <input type="text" class="form-control"  value="غير خاضع" disabled>
 @else
  <input type="text" class="form-control"  value="خاضع" disabled>
 @endif
</div>
</div>

<div class="col-sm-4">
    <div class="form-group">
      <label for="email">سعر البيع الافتراضى</label>
      <input type="text" class="form-control"  value="{{$product->default_sale_price}}" disabled>
    </div>
</div>

<div class="col-sm-4">
    <div class="form-group">
      <label for="email">الخصم الافتراضى</label>
      <input type="text" class="form-control"  value="{{$product->default_discount}}" disabled>
    </div>
</div>

<div class="col-sm-4">
    <div class="form-group">
       <label for="email">التصنيف الرئيسى</label>
        <input type="text" class="form-control"  value="{{$product->category->main->category}}" disabled>
    </div>
  </div>  



<div class="col-sm-4">
<div class="form-group">
  <label for="email">التصنيف الفرعى</label>
    <input type="text" class="form-control"  value="{{$product->category->category}}" disabled>
   </div>
 </div>


<!---------------------------------------------------->
@if($product->type == 1 || $product->type == 2)
<div class="col-sm-4">
<div class="form-group">
  <label for="email">المادة الفعالة (en)</label>
       <input type="text" class="form-control"  value="{{$product->product->react_material_en}}" disabled>
    </div>
</div>

<div class="col-sm-4">
<div class="form-group">
  <label for="email">المادة الفعالة (ar)</label>
       <input type="text" class="form-control"  value="{{$product->product->react_material_ar}}" disabled>
    </div>
</div>


<div class="col-sm-4">
    <div class="form-group">
      <label for="email">المخزن الافتراضى</label>
      <input type="text" class="form-control"  value="{{$product->product->store->store_name}}" disabled>
    </div>
</div>




<div class="col-sm-4">
<div class="form-group">
   <label for="email">حد تنيه انتهاء المخزون</label>
       <input type="text" class="form-control"  value="{{$product->product->stock_limit}}" disabled>
    </div>
</div>


<div class="col-sm-4">
<div class="form-group">
   <label for="email">التركيز</label>
       <input type="text" class="form-control"  value="{{$product->product->concentrate}}" disabled>
    </div>
</div>


 <div class="col-sm-4">
    <div class="form-group">
       <label for="email">سعر الشراء الافتراضى</label>
       <input type="text" class="form-control"  value="{{$product->product->default_buy_price}}" disabled>
    </div>
</div>




<div class="col-sm-4">
<div class="form-group">
   <label for="email">sku رمز المصنع </label>
       <input type="text" class="form-control"  value="{{$product->product->SKU_code}}" disabled>
    </div>
</div>


<div class="col-sm-4">
<div class="form-group">
  <label for="email">نوع تتبع  المخزون</label>
    @if($product->product->track_type == 0)
      <input type="text" class="form-control"  value="التاريخ" disabled>
    @else
      <input type="text" class="form-control"  value="الكمية" disabled>
    @endif
    </div>
</div>


<div class="col-sm-4">
<div class="form-group">
  <label for="email">نوع المنتج</label>
      <input type="text" class="form-control"  value="{{$product->product->type->type}}" disabled>
    </div>
</div>

@endif

</div>



@if($product->type == 1 || $product->type == 2)
<br><br>
<!-- Trigger the modal with a button -->
<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">اضف مخزون جديد</button>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="text-align:center;">اضف مخزون جديد</h4>
      </div>
      <div class="modal-body">
        
  <form action="{{route('add_new_stock')}}" method="post">
  @csrf

  <input type="hidden" class="form-control" value="{{$product->product->id}}" name="product_id" required>  
  <div class="form-group">
    <label for="email">المخزن</label>
    <select class="form-control" name="store_id">
        <option value="-1" disabled selected>اختر المخزن</option>
        @foreach($stores as $value)
        <option value="{{$value->id}}">{{$value->store_name}}</option>
        @endforeach
       </select>
  </div>

  <div class="form-group">
    <label for="email">الكمية</label>
    <input type="text" class="form-control" name="amount" required>
  </div>

  <div class="form-group">
    <label for="email">تاريخ الانتاج</label>
    <input type="date" class="form-control" name="production_date">
  </div>

  <div class="form-group">
    <label for="email">تاريخ الانتهاء</label>
    <input type="date" class="form-control" name="expiration_date" required>
  </div>

  <div class="form-group">
    <label for="email">سعر الشراء</label>
    <input type="text" class="form-control" name="buy_price">
  </div>

  <div class="form-group">
    <label for="email">ملاحظات</label>
    <input type="text" class="form-control" name="notes">
  </div>


  <button type="submit" class="btn btn-primary">حفظ</button>
</form>


</div>
      </div>

    </div>

  </div>



<div class="row">
 <div class="col-sm-12">
  <br>
    <div class="table-responsive">
      <table class="table table-bordered table-striped" id="dynamicTable">  
          <tr>
            <th>#</th>
      			<th>المستخدم</th>
      			<th>رقم فاتورة</th>
      			<th>اسم المورد</th>
      			<th>تاريخ الشراء</th>
            <th>سعر الشراء</th>
            <th>المخزن</th>
            <th>الكمية</th>
            <th>تاريخ الانتاج</th>
            <th>تاريخ الانتهاء</th>
            <th>ملاحظات</th>
			<th>إجراءات</th>
          </tr>
          @foreach($product->product->dates as $index=>$value)
          <tr>  
            <td>{{$index+1}}</td>
            @if($value->purchase_bill_product != null)
              <td>{{$value->purchase_bill_product->bill->user->name}}</td>
        			<td>{{$value->purchase_bill_product->bill->bill_number}}</td>
        			<td>{{$value->purchase_bill_product->bill->supplier->name}}</td>
        			<td>{{$value->purchase_bill_product->bill->bill_date}}</td>
            @else
              <td>{{$product->user->name}}</td>
              <td></td>
              <td></td>
              <td></td>
            @endif
            <td>{{$value->cost}}</td>
            <td>{{$value->store->store_name}}</td>  
            <td>{{$value->quantity}}</td>  
            <td>{{$value->production_date}}</td>  
		    <td>{{$value->expire_date}}</td>  
            <td>{{$value->note}}</td>
			<td>
			<!-- Button to Open the Modal -->
				<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal{{$index+1}}">
				  <i class="fa fa-edit"></i>
				</button>

				<!-- The Modal -->
				<div class="modal" id="myModal{{$index+1}}">
				  <div class="modal-dialog">
					<div class="modal-content">

					  <!-- Modal Header -->
					  <div class="modal-header">
						
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title" style="text-align:center;">تعديل البيانات</h4>
					  </div>

					  <!-- Modal body -->
					  <div class="modal-body">
							<form action="{{route('edit_stock')}}" method="post">
							@csrf
							<input type="hidden" class="form-control" name="stock_id" value="{{$value->id}}">
							  <div class="form-group">
								<label for="email">تاريخ الانتاج:</label>
								<input type="date" class="form-control" name="production_date" value="{{$value->production_date}}">
							  </div>
							  <div class="form-group">
								<label for="email">تاريخ الانتهاء:</label>
								<input type="date" class="form-control" name="expiration_date" value="{{$value->expire_date}}">
							  </div>
							  <div class="form-group">
								<label for="email">الكمية:</label>
								<input type="number" class="form-control" name="quantity" value="{{$value->quantity}}">
							  </div>
                <div class="form-group">
                  <label for="email">سعر الشراء</label>
                  <input type="text" class="form-control" name="buy_price" value="{{$value->cost}}">
                </div>
							  <div class="form-group">
								<label for="email">ملاحظات:</label>
								<input type="text" class="form-control" name="notes" value="{{$value->note}}">
							  </div>
							  <button type="submit" class="btn btn-primary">تعديل</button>
							</form>					  </div>

					

					</div>
				  </div>
				</div>
			</td>			
          </tr> 
          @endforeach 
      </table> 
		</div>
  </div>
</div>

@endif


</div>

</div>

</div>
</div>

</div>






    @endsection