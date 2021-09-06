@extends('admin.layouts.header')

@section('content')

<style>
    .form-group textarea{
        height:60px;
    }
</style>

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
                                            <li><span class="bread-blod">تعريفات المنتجات </span>
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
			
		

<br>


<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">إدارة الفئات الرئيسية</a></li>
    <li><a data-toggle="tab" href="#menu11">إدارة الفئات الفرعية</a></li>
    <li><a data-toggle="tab" href="#menu2">إدارة  انواع المنتجات</a></li>
  </ul>

  <div class="tab-content">

<!-----------------------first tab-------------------------------------------->

    <div id="home" class="tab-pane fade in active">
      <br>
     <div class="panel panel-default">
  <div class="panel-body">
     <!-- Button to Open the Modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModaldept">
 اضافة فئة رئيسية
</button>

<!-- The Modal -->
<div class="modal" id="myModaldept">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="text-align:center;">اضافة فئة رئيسية</h4>
        
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="{{route('add_new_category')}}" method="post">
            @csrf
     <div class="form-group">
        <label for="email">اسم الفئة (en)</label>
        <input type="text" class="form-control"  name="cat_en" id="email" required>
      </div>

      <div class="form-group">
        <label for="email">اسم الفئة (ar)</label>
        <input type="text" class="form-control"  name="cat_ar" id="email" required>
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
        <th>اسم الفئة (en)</th>
         <th>اسم الفئة (ar)</th>
        <th>الاجراءات</th>
      </tr>
    </thead>

    <tbody>
        @foreach($categories as $index=>$value)
      <tr>
        <td>{{$index+1}}</td>
        <td>{{$value->category_en}}</td>
        <td>{{$value->category_ar}}</td>
        <td>
         -
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
 اضافة فئة فرعية
</button>

<!-- The Modal -->
<div class="modal" id="myModalhire">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="text-align:center;">اضافة فئة فرعية</h4>
        
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="{{route('add_new_category')}}" method="post">
            @csrf
  
 <div class="form-group">
        <label for="email">الفئة الرئيسية</label>
        <select class="form-control"  name="cat_val">
          @foreach($categories as $index=>$value)
          <option value="{{$value->id}}">{{$value->category}}</option>
          @endforeach
        </select>
      </div>

     <div class="form-group">
        <label for="email">اسم الفئة الفرعية (en)</label>
        <input type="text" class="form-control"  name="cat_en" id="email" required>
      </div>

      <div class="form-group">
        <label for="email">اسم الفئة الفرعية (ar)</label> 
        <input type="text" class="form-control"  name="cat_ar"  id="email" required>
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
        <th>اسم الفئة الرئيسية</th>
        <th>اسم الفئة الفرعية (en)</th>
         <th>اسم الفئة الفرعية (ar)</th>
      </tr>
    </thead>
    <tbody>
      @foreach($sub_categories as $index=>$value)
      <tr>
        <td>{{$index+1}}</td>
        <td>{{$value->main->category}}</td>
        <td>{{$value->category_en}}</td>
        <td>{{$value->category_ar}}</td>
        <td>
        -
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
 اضافة انواع المنتجات
</button>

<!-- The Modal -->
<div class="modal" id="myModaljoblevel">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="text-align:center;">اضافة انواع المنتجات</h4>
        
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="{{route('add_new_type')}}" method="post">
            @csrf


     <div class="form-group">
        <label for="email">نوع المنتج (en)</label>
        <input type="text" class="form-control"  name="type_en" id="email" required>
      </div>

      <div class="form-group">
        <label for="email">نوع المنتج (ar)</label>
        <input type="text" class="form-control"  name="type_ar" id="email" required>
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
        <th>نوع المنتج (en)</th>
         <th>نوع المنتج (ar)</th>
        <th>الاجراءات</th>
      </tr>
    </thead>
    <tbody>
      @foreach($pro_types as $index=>$value)
      <tr>
        <td>{{$index+1}}</td>
        <td>{{$value->type_en}}</td>
        <td>{{$value->type_ar}}</td>            
        <td>
          -
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

    