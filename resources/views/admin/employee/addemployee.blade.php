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
                                            <li><span class="bread-blod">اضافة الموظفين</span>
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
<form action="{{route('add_new_employee')}}" method="post" enctype="multipart/form-data">
@csrf

<div class="row">

<div class="col-md-12">
  <input type="hidden" name="dept_name" id="department_id">
    <div class="form-group">
      <label for="email">الادارة التابع لها</label>
      <select class="form-control" onChange="department_val()" id="department">
        <option value="-1" disabled selected>اختر الإدارة</option>
        @foreach($department as $index=>$value)
        <option value="{{$index}}">{{$value->department}}</option>
        @endforeach
      </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">اسم الموظف (en)</label>
      <input type="text" class="form-control" name="emp_name_en" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">اسم الموظف (ar)</label>
      <input type="text" class="form-control" name="emp_name_ar" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">ارفاق صورة</label>
      <input type="file" class="form-control"   name="emp_photo" required>
    </div>
</div>

<div class="col-md-4">
  <div class="form-group">
  <label for="email">حالة الموظف</label>
    <select class="form-control"   name="emp_status">
        @foreach($activation as $value)
        <option value="{{$value->id}}">{{$value->activation}}</option>
        @endforeach
      </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">البريد الالكتروني</label>
      <input type="email" class="form-control" name="emp_email" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">لغة النظام للموظف</label>
      <select class="form-control"   name="sys_lang">
        <option value="ar">عربي</option>
        <option value="en">انجليزي</option>
      </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">الصلاحيات المسموح بها</label>
      <select class="form-control"   name="emp_permission">
        <option value="1">مدير للنظام</option>
        <option value="2">موظف مشتريات</option>
      </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">الجنس</label>
      <select class="form-control" name="emp_gender">
        <option value="m">ذكر</option>
        <option value="f">انثي</option>
      </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">الجنسية</label>
        <select class="form-control" name="emp_nationality">
        @foreach($nationality as $value)
        <option value="{{$value->id}}">{{$value->nationality_ar}}</option>
        @endforeach
      </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">عنوان الموظف في دولته</label>
      <input type="text" class="form-control" name="emp_homeaddress" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">رقم التواصل في دولته</label>
      <input type="text" class="form-control"   name="emp_homephone" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">عنوان العمل</label>
      <input type="text" class="form-control" name="emp_workaddress" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">رقم التواصل في العمل</label>
      <input type="text" class="form-control"   name="emp_workphone" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">تاريخ التعيين</label>
      <input type="date" class="form-control" name="hiring_date" required>
    </div>
</div>


<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">الوظيفة</label>
        <select class="form-control" name="emp_jop" onChange="job_val()" id="jobs">
      </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">المستوي الوظيفي</label>
      <select class="form-control" name="jop_level" id="levels">
      </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">نوع الدوام</label>
     <select class="form-control" name="period_type">
        @foreach($period_type as $value)
        <option value="{{$value->id}}">{{$value->period_type}}</option>
        @endforeach
      </select>
    </div>
</div>



<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">تاريخ نهاية العقد</label>
      <input type="date" class="form-control" name="hiring_deadline" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">نوع العقد</label>
      <select class="form-control" name="contract_type">
        @foreach($contract_type as $value)
        <option value="{{$value->id}}">{{$value->contract_type}}</option>
        @endforeach
      </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">العطلات الرسمية</label>
        <select class="form-control"   name="emp_holidays">
        <option value="1">عيد الفطر</option>
        <option value="2">عيد الاضحي</option>
      </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">سياسة الاجازات السنوية</label>
      <select class="form-control"   name="holidays_policy">
        <option value="1">شهر</option>
        <option value="2">شهرين</option>
      </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">تاريخ الاجازى القادمة</label>
      <input type="date" class="form-control" name="next_holiday_date" required>
    </div>
</div>

<div class="col-md-12">
<div class="form-group form-check">
    <label class="form-check-label">
      <input class="form-check-input" type="checkbox" value="1" name="login_access"> تفعيل دخول النظام
    </label>
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



<script>
  function department_val() {

    var z = <?php echo $department; ?>;
    var jv = document.getElementById("department").value;
    document.getElementById("department_id").value = z[jv].id;
    //document.getElementById("lis_val").value = d;
    var d = z[jv].jobs;
    //console.log(z[d].jobs);

    var catOptions = "";
    catOptions += "<option value='' disabled selected=''>إختر الوظيفة</option>";
     if (d.length == 0) {
      //document.getElementById("subcat").innerHTML = "<option></option>";
      }else {
       var locale = '{{ config('app.locale') }}';
       if(locale == 'ar')
        var name = d.map(({job_ar}) => job_ar);
    else
    var name = d.map(({job_en}) => job_en);
        console.log(name);
        var id = d.map(({levels}) => levels);
        for (x in name) {
          var y = id[x];
          catOptions += "<option value ='"+JSON.stringify(y)+"'>" + name[x] + "</option>";
          //console.log("ddd",y);
        }
        
      }
      document.getElementById("jobs").innerHTML = catOptions;
  }

  function job_val() {

    var d = JSON.parse(document.getElementById("jobs").value);
    //document.getElementById("lis_val").value = d;
    //console.log(d);

    var catOptions = "";
    catOptions += "<option value='' disabled selected=''>إختر المستوى الوظيفي</option>";
     if (d.length == 0) {
      //document.getElementById("subcat").innerHTML = "<option></option>";
      }else {
       var locale = '{{ config('app.locale') }}';
       if(locale == 'ar')
          var name = d.map(({job_ar}) => job_ar);
       else
          var name = d.map(({job_en}) => job_en);
        console.log(name);
        var id = d.map(({id}) => id);
        console.log(id);
        for (x in name) {
          catOptions += "<option value ='" + id[x] +"'>" + name[x] + "</option>";
        }
        //console.log("ddd",d);
      }
      document.getElementById("levels").innerHTML = catOptions;
  }
</script>


    @endsection

    