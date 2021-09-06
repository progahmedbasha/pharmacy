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
                                            <li><span class="bread-blod">تعديل بيانات الموظفين</span>
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
<form action="{{route('edit_employee')}}" method="post" enctype="multipart/form-data">
@csrf

<input type="hidden" name="emp_id" value="{{$empdetail->id}}">
<div class="row">

<div class="col-md-4">
    <div class="form-group">
      <label for="email">اسم الموظف (en)</label>
      <input type="text" class="form-control" name="emp_name_en" value="{{$empdetail->name_en}}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">اسم الموظف (ar)</label>
      <input type="text" class="form-control" name="emp_name_ar" value="{{$empdetail->name_ar}}" required>
    </div>
</div>


<div class="col-md-4">
    <div class="form-group">
      <label for="email">البريد الالكتروني</label>
      <input type="email" class="form-control" name="emp_email" value="{{$empdetail->email}}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">عنوان الموظف في دولته</label>
      <input type="text" class="form-control" name="emp_homeaddress" value="{{$empdetail->home_address}}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">رقم التواصل في دولته</label>
      <input type="text" class="form-control"   name="emp_homephone" value="{{$empdetail->home_phone}}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">عنوان العمل</label>
      <input type="text" class="form-control" name="emp_workaddress" value="{{$empdetail->job_address}}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">رقم التواصل في العمل</label>
      <input type="text" class="form-control"   name="emp_workphone" value="{{$empdetail->job_phone}}" required>
    </div>
</div>


<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">تاريخ نهاية العقد</label>
      <input type="date" class="form-control" name="hiring_deadline" value="{{$empdetail->end_date}}" required>
    </div>
</div>


<div class="col-md-12">
    <button type="submit" class="btn btn-primary">حفظ</button>
  </div>  

  </form>
</div>
</div>

            </div>
        </div>


    @endsection

    