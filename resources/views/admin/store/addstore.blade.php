@extends('admin.layouts.header')

@section('content')

<style>
#main_store1{
  display:none;
}
</style>


     
        <div class="analytics-sparkle-area">
            <div class="container-fluid">
      <br>
      <div class="panel panel-default">
          <div class="panel-heading">اضافة مستودع</div>
  <div class="panel-body">


<form action="{{route('add_new_store')}}" method="post">
  @csrf
    
    <div class="row">


 <div class="col-sm-4">
    <div class="form-group">
      <label for="email">اسم المستودع بالإنجليزي</label>
      <input type="text" class="form-control"  name="store_name_en" required>
    </div>
 </div>

 <div class="col-sm-4">
    <div class="form-group">
      <label for="email">اسم المستودع بالعربي</label>
      <input type="text" class="form-control"  name="store_name_ar" required>
    </div>
</div>



 <div class="col-sm-4">
<div class="form-group">
<label for="email">القسم التابع له</label>
      <select class="form-control" id="sel1" name="store_dept">
        @foreach($department as $value)
        <option value="{{$value->id}}">{{$value->department}}</option>
        @endforeach
      </select>
    </div>
</div>


 <div class="col-sm-4">
    <div class="form-group">
      <label for="email">النوع </label><br>
       <input type="radio"  name="store_type" id="store_type1" onclick="mainstore_disable()" value="0" checked>&nbsp;&nbsp;رئيسي&nbsp;&nbsp;
  <input type="radio"  name="store_type" id="store_type2" onclick="mainstore_enable()" value="1" >&nbsp;&nbsp;&nbsp;فرعي
    </div>
</div>








 <div class="col-sm-4" id="main_store1">

<div class="form-group">
  <label for="email">المستودع الرئيسى </label>
 <select class="form-control" id="main_store" name="main_store">
  @foreach($main_store as $value)
        <option value="{{$value->id}}">{{$value->store_name}}</option>
  @endforeach
      </select>
</div>
</div>




 <div class="col-sm-4">
  <div class="form-group">
    <label for="email">العنوان</label>
      <input type="text" class="form-control"  name="store_address" required>
    </div>
</div>

 <div class="col-sm-4">
    <div class="form-group">
       <label for="email">المدينة </label>
      <input type="text" class="form-control"  name="store_city" required>
    </div>
</div>

 <div class="col-sm-4">
<div class="form-group">
   <label for="email">المنطقة </label>
      <input type="text" class="form-control"  name="store_area" required>
    </div>
</div>

 <div class="col-sm-4">
<div class="form-group">
<label for="email">تصنيف المخزن</label>
      <select class="form-control" id="sel1" name="store_classify">
        @foreach($classify as $value)
        <option value="{{$value->id}}">{{$value->classify}}</option>
        @endforeach
      </select>
    </div>
</div>


 <div class="col-sm-12">
<button type="submit" class="btn btn-primary">حفظ</button>

</div>

</div><!-------row----->

</form>

</div>
</div>

</div>
</div>
<br><br>
</div>

<script>

function mainstore_enable(){
document.getElementById("main_store1").style.display = "block";
}

function mainstore_disable(){
document.getElementById("main_store1").style.display = "none";
}

</script>


 @endsection