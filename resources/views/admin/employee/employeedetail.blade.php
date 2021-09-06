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
                                            <li><span class="bread-blod">بيانات الموظف</span>
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
			<div class="col-md-6">
    <a href="{{url('editemployee')}}/{{$empdetail->id}}" class="btn btn-info">
            <i class="fa fa-edit" aria-hidden="true"></i> تعديل بيانات</a>  
</div>
                      <div class="col-md-6" style="text-align:left;">
            @if($empdetail->isActive != 2)
            <a href="{{url('customer_activation')}}/{{$empdetail->id}}/2" class="btn btn-warning">
            <i class="fa fa-minus-circle" aria-hidden="true"></i> تعليق</a> 
            @endif
            @if($empdetail->isActive != 1)
            <a href="{{url('customer_activation')}}/{{$empdetail->id}}/1" class="btn btn-success">
            <i class="fa fa-check" aria-hidden="true"></i> تفعيل</a> 
            @endif
            @if($empdetail->isActive != 3)
            <a href="{{url('customer_activation')}}/{{$empdetail->id}}/3" class="btn btn-danger">
            <i class="fa fa-ban" aria-hidden="true"></i> حظر</a> 
            @endif 
<br>
            <span>حالة</span>:&nbsp;{{$empdetail->activation->activation}}
          </div>
</div>

<div class="panel panel-default">
  <div class="panel-body">

<div class="row">

<div class="col-md-12">
    <div class="form-group">
      <label for="email">الادارة التابع لها</label>
        <input type="text" class="form-control" value="{{$empdetail->department->department}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">اسم الموظف</label>
      <input type="text" class="form-control" value="{{$empdetail->name}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">ارفاق صورة</label>
      <input type="text" class="form-control"   value="{{$empdetail->image}}" disabled>
    </div>
</div>

<div class="col-md-4">
  <div class="form-group">
  <label for="email">حالة الموظف</label>
    <input type="text" class="form-control"   value="{{$empdetail->activation->activation}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">البريد الالكتروني</label>
      <input type="text" class="form-control"   value="{{$empdetail->email}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">لغة النظام للموظف</label>
     <input type="text" class="form-control"   value="{{$empdetail->sys_lang}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">الصلاحيات المسموح بها</label>
      <input type="text" class="form-control"   value="-" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">الجنس</label>
      <input type="text" class="form-control"   value="{{$empdetail->gender}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">الجنسية</label>
        <input type="text" class="form-control"   value="{{$empdetail->nationality->nationality_ar}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">عنوان الموظف في دولته</label>
      <input type="text" class="form-control"   value="{{$empdetail->home_address}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">رقم التواصل في دولته</label>
      <input type="text" class="form-control"   value="{{$empdetail->home_phone}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">عنوان العمل</label>
      <input type="text" class="form-control"   value="{{$empdetail->job_address}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">رقم التواصل في العمل</label>
      <input type="text" class="form-control"   value="{{$empdetail->job_phone}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">تاريخ التعيين</label>
      <input type="text" class="form-control"   value="{{$empdetail->hiring_date}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">الوظيفة</label>
        <input type="text" class="form-control"   value="{{$empdetail->job->main->job}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">المستوي الوظيفي</label>
      <input type="text" class="form-control"   value="{{$empdetail->job->job}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">نوع الدوام</label>
     <input type="text" class="form-control"   value="{{$empdetail->period_type->period_type}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">تاريخ نهاية العقد</label>
      <input type="text" class="form-control"   value="{{$empdetail->end_date}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">نوع العقد</label>
      <input type="text" class="form-control"   value="{{$empdetail->contract_type->contract_type}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">العطلات الرسمية</label>
        <input type="text" class="form-control"   value="-" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">سياسة الاجازات السنوية</label>
      <input type="text" class="form-control"   value="-" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">تاريخ الاجازى القادمة</label>
      <input type="text" class="form-control"   value="-" disabled>
    </div>
</div>

<div class="col-md-12">
  <label for="pwd">تفعيل دخول النظام</label>
      <input type="text" class="form-control"   value="{{$empdetail->isLogged}}" disabled>
</div>

  </form>
</div>
</div>

            </div>
        </div>


    @endsection

    