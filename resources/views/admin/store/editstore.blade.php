@extends('admin.layouts.header')

@section('content')
          <div class="breadcome-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="breadcome-list">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <ul class="breadcome-menu">
                                            <!--<li><a href="#">Home</a> <span class="bread-slash">/</span>
                                            </li>-->
                                            <li><span class="bread-blod">تعديل بيانات المستودع</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
     
        <div class="analytics-sparkle-area">
            <div class="container-fluid">
      
      <div class="panel panel-default">
  <div class="panel-body">


<form action="{{route('edit_store')}}" method="post">
  @csrf
    
     <input type="hidden" name="store_id" value="{{$stdetail->id}}" >
    <div class="row">


 <div class="col-sm-4">

    <div class="form-group">
      <label for="email">اسم المستودع بالإنجليزي</label>
      <input type="text" class="form-control"  name="store_name_en" value="{{$stdetail->store_name_en}}" required>
    </div>
  </div>

 <div class="col-sm-4">
    <div class="form-group">
      <label for="email">اسم المستودع بالعربي</label>
      <input type="text" class="form-control"  name="store_name_ar" value="{{$stdetail->store_name_ar}}" required>
    </div>
  </div>

   <div class="col-sm-4">

  <div class="form-group">
    <label for="email">العنوان</label>
      <input type="text" class="form-control"  name="store_address" value="{{$stdetail->address}}"required>
    </div>
</div><!-------col---->


 <div class="col-sm-4">
    <div class="form-group">
       <label for="email">المدينة </label>
      <input type="text" class="form-control"  name="store_city" value="{{$stdetail->city}}" required>
    </div>
</div><!-------col---->


 <div class="col-sm-4">
<div class="form-group">
   <label for="email">المنطقة </label>
      <input type="text" class="form-control"  name="store_area" value="{{$stdetail->area}}" required>
    </div>
</div><!-------col---->

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




 @endsection