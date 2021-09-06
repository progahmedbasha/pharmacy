@extends('doctor.layouts.header')

@section('content')


<div class="container">

<br>
<div class="row ">
	<div class="col-md-4"></div>
<div class="col-md-4">
<div class="panel panel-default">
  <div class="panel-body">
  	<center>
  	<i class="fa fa-user-circle" aria-hidden="true" style="font-size:100px;"></i>

<hr>
{{auth()->user()->name}}
<hr>
{{auth()->user()->email}}
<hr>
<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> تعديل بيانات الحساب الشخصي</button>
</center>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> تعديل بيانات الحساب الشخصي</h4>
      </div>
      <div class="modal-body">
        <form action="{{route('edit_profile')}}" method="post">
        	@csrf
  <div class="form-group">
    <label for="email">اسم الطبيب (ar)</label>
    <input type="text" class="form-control" value="{{$doctor->name_ar}}" name="d_name_ar" required>
  </div>
  <div class="form-group">
    <label for="email">اسم الطبيب (en)</label>
    <input type="text" class="form-control" value="{{$doctor->name_en}}" name="d_name_en" required>
  </div>
  <div class="form-group">
    <label for="pwd">البريد الالكتروني</label>
    <input type="email" class="form-control" value="{{$doctor->email}}" name="d_email" required>
  </div>
  <div class="form-group">
    <label for="pwd">رقم الهاتف</label>
    <input type="text" class="form-control" value="{{$doctor->phone}}" name="d_phone" required>
  </div>
  <div class="form-group">
    <label for="pwd">نوع العيادة</label>
    <input type="text" class="form-control" value="{{$doctor->clinic_type}}" name="d_clinic_type" required>
  </div>

  <button type="submit" class="btn btn-primary">تعديل البيانات</button>
</form>
      </div>

    </div>

  </div>
</div>

  </div>
</div>


</div>
</div>
<hr>
<div class="row">

<div class="col-md-4">
<div class="panel panel-default">
	 <div class="panel-heading"><i class="fa fa-cogs" aria-hidden="true"></i> تعديل كلمة المرور</div>
  <div class="panel-body">
  	<form action="{{route('edit_password')}}" method="post">
  		@csrf
  <div class="form-group">
    <label for="email">كلمة المرور الحالية</label>
    <input type="text" class="form-control" name="current_pass" required>
  </div>
  <div class="form-group">
    <label for="pwd">كلمة المرور الجديدة</label>
    <input type="text" class="form-control" name="new_pass" required>
  </div>

  <button type="submit" class="btn btn-primary">تعديل كلمة المرور</button>
</form>
  </div>
</div>


</div>

</div>

</div>

@endsection

    