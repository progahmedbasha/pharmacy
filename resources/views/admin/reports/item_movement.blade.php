@extends('admin.layouts.header')

@section('content')

     
        <div class="analytics-sparkle-area">
            <div class="container-fluid">
<br>			
      

      <iframe id="iframe" src="" style="display:none;"></iframe>

			<div class="row">
		
			</div>
<br>

<div class="panel panel-default">
  <div class="panel-body">

  	<div class="row">
  	

<div class="col-md-2">  
<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">عدد الصفوف : {{$paginationVal}}
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a  href="{{url('Item_movement')}}/10/{{$item_data->id}}">10</a></li>
    <li><a  href="{{url('Item_movement')}}/25/{{$item_data->id}}">25</a></li>
    <li><a  href="{{url('Item_movement')}}/50/{{$item_data->id}}">50</a></li>
    <li><a  href="{{url('Item_movement')}}/100/{{$item_data->id}}">100</a></li>
  </ul>
</div>
</div>
<div class="col-md-2">
<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">رقم الصفحة : {{$sell_data->currentPage()}}
  <span class="caret"></span></button>
  <ul class="dropdown-menu" style="overflow-y: scroll;height:200px;">
  	@for($i=1; $i<=$sell_data->lastPage();$i++)
    <li><a  href="{{url('Item_movement')}}/{{$paginationVal}}/{{$item_data->id}}?page={{$i}}">{{$i}}</a></li>
    @endfor
  </ul>
</div>
</div>
<div class="col-md-4">
      <form method="get" class="form-inline" action="{{url('Item_movement')}}/{{$paginationVal}}/{{$item_data->id}}">
  	 من:&nbsp;<input  name="date_from" type="date" required><br>
  	 إلي: <input  name="date_to" type="date" required>
     <button type="submit">بحث</button>
   </form>
</div>
</div>
<br>

<div class="col-md-6">
    <table class="table table-striped ">
        <thead>
            <tr>
                <th>إسم المنتج</th>
                <th>{{$item_data->name}}</th>
            </tr>
            <tr>
                <th>الكود</th>
                <th>{{$item_data->code}}</th>
            </tr>
            <tr>
                <th>التصنيف</th>
                <th>{{$item_data->category->category_ar}}</th>
            </tr>
        </thead>
        
        
    </table>
</div>


<div class="table-responsive col-md-12">
<table class="table table-bordered">
    <thead>
      <tr>
        <th>رقم الفاتورة</th>
        <th>باركود الفاتورة</th>
        <th>تاريخ الفاتورة</th>
        <th>السعر</th>
        <th>سعر التخفيض</th>
        <th>قيمة الضريبة</th>
        <th>السعر النهائى</th>
        <th>الكمية</th>
		
      </tr>
    </thead>
    <tbody>
     @forelse($sell_data as $index=>$value)
      <tr>
        <td>{{$value->bill_id}}</td>
        <td>{{$value->bill->bill_number}}</td>
        <td>{{$value->bill->bill_date}}</td>
        <td>{{$value->price}}</td>
        <td>{{$value->product_discount}}</td>
        <td>{{$value->tax_value}}</td>
        <td>{{$value->total_price}}</td>
        <td>{{$value->quantity}}</td>
        
        @if(!is_null($value->bill->return_bills))
            @foreach($value->bill->return_bills as $return_bill)
                </tr>
                <tr>
                    <td>{{$return_bill->bill_id}}</td>
                    <td>{{$return_bill->return_number}}</td>
                    <td>{{$return_bill->return_date}}</td>
                    <td colspan="5" class="text-center text-danger">فاتورة مرتجع</td>
                    
            @endforeach
            
        @endif
		
      </tr>
      
      
      
      
      @empty
        <tr><td colspan="8" class="text-center">لا يوجد بيانات للعرض</td></tr>
      @endforelse
      
    </tbody>
  </table>
  
  
</div>
</div>
</div>
            </div>
        </div>

<script type="text/javascript">
  function openmodle(url){
    document.getElementById("iframe").src=url;
  }
</script>


    @endsection

    