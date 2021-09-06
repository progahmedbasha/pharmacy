@extends('admin.layouts.header')

@section('content')

<style>
    .form-group textarea{
        height:60px;
    }
</style>


     
        <div class="analytics-sparkle-area">
            <div class="container-fluid">
			
		

<br>


<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">إدارة الاقسام</a></li>
    <li><a data-toggle="tab" href="#menu11">إدارة التعيين</a></li>
    <li><a data-toggle="tab" href="#menu2">إدارة المستوي الوظيفي</a></li>
  </ul>

  <div class="tab-content">

<!-----------------------first tab-------------------------------------------->

    <div id="home" class="tab-pane fade in active">
      <br>
     <div class="panel panel-default">
  <div class="panel-body">
     <!-- Button to Open the Modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModaldept">
 اضافة قسم جديد
</button>

<!-- The Modal -->
<div class="modal" id="myModaldept">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="text-align:center;">اضافة قسم</h4>
        
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="{{route('add_new_department')}}" method="post">
            @csrf
     <div class="form-group">
        <label for="email">اسم القسم (en)</label>
        <input type="text" class="form-control"  name="dept_name_en" id="email" required>
      </div>

      <div class="form-group">
        <label for="email">اسم القسم (ar)</label>
        <input type="text" class="form-control"  name="dept_name_ar" id="email" required>
      </div>

     <div class="form-group">
        <label for="email">الوصف</label>
        <textarea rows="2" class="form-control"  name="dept_desc" id="email"></textarea>
      </div>


      <div class="form-group">
        <label for="email">رقم اليوم</label>
        <input type="number" class="form-control" min="1" max="31" name="day_val" required>
      </div>
    
     <div class="form-group">
        <label for="email">الشهر</label>
        <select class="form-control"  name="month_val" >
            @foreach($months as $value)
                <option value="{{$value->id}}">{{$value->month}}</option>
            @endforeach
        </select>
      </div>


          <div class="form-group">
      <label for="email">الحالة</label><br>
      
      <input type="radio"  name="isActive" value="1" checked>&nbsp;&nbsp;&nbsp;نشط&nbsp;&nbsp;
  <input type="radio"  name="isActive" value="0">&nbsp;&nbsp;&nbsp;غير نشط

    </div>

 
      <button type="submit" class="btn btn-primary">حفظ</button>
    </form>
      </div>


    </div>
  </div>
</div>

<br><br>
<div class="table-responsive">
 <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>اسم القسم (en)</th>
         <th>اسم القسم (ar)</th>
          <th>الوصف</th>
          <th>التاريخ المالي</th>
           <th>الحالة</th>
        <th>الاجراءات</th>
      </tr>
    </thead>
    <tbody>
        @foreach($departments as $index=>$value)
      <tr>
        <td>{{$index+1}}</td>
        <td>{{$value->department_en}}</td>
         <td>{{$value->department_ar}}</td>
          <td>{{$value->description}}</td>
          <td>{{$value->finance_date}}/{{$value->finance_month}}</td>
          @if($value->status == 1)
           <td>نشط</td>
           @else
           <td>غير نشط</td>
           @endif
        <td>
            @if($value->status == 0)
            <a href="{{url('department_activation')}}/{{$value->id}}/1" class="btn btn-success"><i class="fa fa-check"></i></a>
            @else
            <a href="{{url('department_activation')}}/{{$value->id}}/0" class="btn btn-danger"><i class="fa fa-ban"></i></a>
            @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>


</div>
</div>
    </div>
<!-----------------------second tab-------------------------------------------->

    <div id="menu11" class="tab-pane fade">
      <br>
     <div class="panel panel-default">
  <div class="panel-body">
     <!-- Button to Open the Modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalhire">
 اضافة تعيين جديد
</button>

<!-- The Modal -->
<div class="modal" id="myModalhire">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="text-align:center;">اضافة تعيين</h4>
        
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="{{route('add_new_job')}}" method="post">
            @csrf
     <div class="form-group">
        <label for="email">اسم القسم </label>
        <select class="form-control"  name="dept_id" id="email">
            @foreach($departments as $value)
        <option value="{{$value->id}}">{{$value->department}}</option>
        @endforeach
        </select>
      </div>

     <div class="form-group">
        <label for="email">اسم الوظيفة (en)</label>
        <input type="text" class="form-control"  name="job_name_en" id="email" required>
      </div>

      <div class="form-group">
        <label for="email">اسم الوظيفة (ar)</label> 
        <input type="text" class="form-control"  name="job_name_ar"  id="email" required>
      </div>

     <div class="form-group">
        <label for="email">الوصف</label>
        <textarea rows="2" class="form-control"  name="job_desc" id="email"></textarea>
      </div>

          <div class="form-group">
      <label for="email">الحالة</label><br>
      
      <input type="radio"  name="isActive" value="1" checked>&nbsp;&nbsp;&nbsp;نشط&nbsp;&nbsp;
  <input type="radio"  name="isActive" value="0">&nbsp;&nbsp;&nbsp;غير نشط

    </div>

 
      <button type="submit" class="btn btn-primary">حفظ</button>
    </form>
      </div>


    </div>
  </div>
</div>

<br><br>
<div class="table-responsive">
 <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>القسم</th>
        <th>اسم الوظيفة (en)</th>
         <th>اسم الوظيفة (ar)</th>
          <th>الوصف</th>
           <th>الحالة</th>
        <th>الاجراءات</th>
      </tr>
    </thead>
    <tbody>
      @foreach($jobs as $index=>$value)
      <tr>
        <td>{{$index+1}}</td>
         <td>{{$value->department->department}}</td>
          <td>{{$value->job_en}}</td>
          <td>{{$value->job_ar}}</td>
          <td>{{$value->description}}</td>
            @if($value->status == 1)
           <td>نشط</td>
           @else
           <td>غير نشط</td>
           @endif
        <td>
            @if($value->status == 0)
            <a href="{{url('job_activation')}}/{{$value->id}}/1" class="btn btn-success"><i class="fa fa-check"></i></a>
            @else
            <a href="{{url('job_activation')}}/{{$value->id}}/0" class="btn btn-danger"><i class="fa fa-ban"></i></a>
            @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>


</div>
</div>
    </div>

    <!-----------------------third tab-------------------------------------------->

    <div id="menu2" class="tab-pane fade">
      <br>
     <div class="panel panel-default">
  <div class="panel-body">
     <!-- Button to Open the Modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModaljoblevel">
 اضافة مستوي وظيفي جديد
</button>

<!-- The Modal -->
<div class="modal" id="myModaljoblevel">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="text-align:center;">اضافة مستوي وظيفي</h4>
        
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="{{route('add_new_job')}}" method="post">
            @csrf
     <div class="form-group">
        <label for="email">اسم الوظيفة </label>
        <select class="form-control"  name="job_id" id="email">
            @foreach($jobs as $value)
        <option value="{{$value->id}}">{{$value->job}}</option>
        @endforeach
        </select>
      </div>

     <div class="form-group">
        <label for="email">المستوي الوظيفي (en)</label>
        <input type="text" class="form-control"  name="job_name_en" id="email" required>
      </div>

      <div class="form-group">
        <label for="email">المستوي الوظيفي (ar)</label>
        <input type="text" class="form-control"  name="job_name_ar" id="email" required>
      </div>

     <div class="form-group">
        <label for="email">الوصف</label>
        <textarea rows="2" class="form-control"  name="job_desc" id="email"></textarea>
      </div>

          <div class="form-group">
      <label for="email">الحالة</label><br>
      
      <input type="radio"  name="isActive" value="1" checked>&nbsp;&nbsp;&nbsp;نشط&nbsp;&nbsp;
  <input type="radio"  name="isActive" value="0">&nbsp;&nbsp;&nbsp;غير نشط

    </div>

 
      <button type="submit" class="btn btn-primary">حفظ</button>
    </form>
      </div>


    </div>
  </div>
</div>

<br><br>
<div class="table-responsive">
 <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>اسم الوظيفة</th>
        <th>المستوي الوظيفي (en)</th>
         <th>المستوي الوظيفي (ar)</th>
          <th>الوصف</th>
           <th>الحالة</th>
        <th>الاجراءات</th>
      </tr>
    </thead>
    <tbody>
      @foreach($levels as $index=>$value)
      <tr>
        <td>{{$index+1}}</td>
         <td>{{$value->main->job}}</td>
          <td>{{$value->job_en}}</td>
          <td>{{$value->job_ar}}</td>
          <td>{{$value->description}}</td>
            @if($value->status == 1)
           <td>نشط</td>
           @else
           <td>غير نشط</td>
           @endif
        <td>
            @if($value->status == 0)
            <a href="{{url('job_activation')}}/{{$value->id}}/1" class="btn btn-success"><i class="fa fa-check"></i></a>
            @else
            <a href="{{url('job_activation')}}/{{$value->id}}/0" class="btn btn-danger"><i class="fa fa-ban"></i></a>
            @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>


</div>
</div>
    </div>

  </div>


            </div>
        </div>


    @endsection

    