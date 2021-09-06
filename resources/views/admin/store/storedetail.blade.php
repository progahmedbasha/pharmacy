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
                                            <li><span class="bread-blod">بيانات المستودع</span>
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
      
<a href="{{url('editstore')}}/{{$stdetail->id}}" class="btn btn-info">
            <i class="fa fa-edit" aria-hidden="true"></i> تعديل بيانات</a>
<br><br>

      <div class="panel panel-default">
  <div class="panel-body">


    
    <div class="row">

 <div class="col-sm-8">
<div class="form-group">
<label for="email">رقم المستودع</label>
<input type="text" class="form-control"  value="{{$stdetail->store_code}}" disabled>
    </div>
 </div>

 <div class="col-sm-4">
<div class="form-group">
<label for="email">القسم التابع له</label>
<input type="text" class="form-control"  value="{{$stdetail->department->department}}" disabled>
    </div>
 </div>


 <div class="col-sm-4">

    <div class="form-group">
      <label for="email">اسم المستودع</label>
      <input type="text" class="form-control"  value="{{$stdetail->store_name}}" disabled>
    </div>

  <div class="form-group">
    <label for="email">العنوان</label>
      <input type="text" class="form-control"  value="{{$stdetail->address}}" disabled>
    </div>



</div><!-------col---->


 <div class="col-sm-4">


    <div class="form-group">
      <label for="email">النوع </label>
      @if($stdetail->store_type == 0)
     <input type="text" class="form-control"  value="رئيسي" disabled>
     @else
     <input type="text" class="form-control"  value="فرعي" disabled>
     @endif
    </div>



    <div class="form-group">
       <label for="email">المدينة </label>
      <input type="text" class="form-control"  value="{{$stdetail->city}}" disabled>
    </div>




</div><!-------col---->


 <div class="col-sm-4">
@if($stdetail->store_type == 1)
<div class="form-group">
  <label for="email">المستودع الرئيسى </label>
<input type="text" class="form-control"  value="{{$stdetail->main_store->store_name}}" disabled>
</div>
@endif

<div class="form-group">
   <label for="email">المنطقة </label>
      <input type="text" class="form-control"  value="{{$stdetail->area}}" disabled>
    </div>




</div><!-------col---->


</div><!-------row----->

</form>

</div>
</div>

</div>
</div>
<br><br>
</div>




 @endsection