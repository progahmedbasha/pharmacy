@extends('admin.layouts.header')

@section('content')

    <link rel="stylesheet" href="{{ asset('dropify/dist/css/dropify.min.css')}}">


     <br><br>
        <div class="analytics-sparkle-area">
            <div class="container-fluid">
			<br>
			<div class="panel panel-default">
        <div class="panel-heading">تعديل الإعدادات العامة</div>


<br><br>
  <div class="panel-body">

<form action="{{route('MainSettings.update', $setting->id)}}" method="post" enctype="multipart/form-data">
@csrf
    @method('PUT')

<input type="hidden" class="form-control"  name="id" value="{{ $setting->id }}" required>


 <div class="row">

 <div class="col-sm-4">
    <div class="form-group">
      <label for="email"> اسم الموقع (en)</label>
      <input type="text" class="form-control"  name="site_name_en" value="{{ $setting->site_name_en }}" required>

	 @error('site_name_en')
    <div class="alert alert-danger">{{ $message }}</div>
   @enderror
	</div>
  </div>

   <div class="col-sm-4">
    <div class="form-group">
      <label for="email"> اسم الموقع (ar)</label>
      <input type="text" class="form-control"  name="site_name" value="{{$setting->site_name}}" required>

		   @error('site_name')
    <div class="alert alert-danger">{{ $message }}</div>


   @enderror
	</div>
  </div>

     <div class="col-sm-4">
         <div class="form-group">
             <label for="email"> رقم الهاتف</label>
             <input type="text" class="form-control"  name="phone" value="{{$setting->phone}}" required>

             @error('phone')
             <div class="alert alert-danger">{{ $message }}</div>


             @enderror
         </div>
     </div>

     <div class="col-sm-4">
         <div class="form-group">
             <label for=""> الشعار </label>
             <input type="file" class="form-control dropify"  name="logo" data-default-file="{{Storage::url('uploads/'.$setting->logo)}}" >

             @error('logo')
             <div class="alert alert-danger">{{ $message }}</div>


             @enderror
         </div>
     </div>

     <div class="col-sm-4">
         <div class="form-group">
             <label for=""> الأيكونة </label>
             <input type="file" class="form-control dropify"  name="fav_icon" data-default-file="{{Storage::url('uploads/'.$setting->fav_icon)}}">

             @error('fav_icon')
             <div class="alert alert-danger">{{ $message }}</div>


             @enderror
         </div>
     </div>





<!---------------------------------------------------->
</div>



<div class="col-sm-12">
<button type="submit" class="btn btn-primary">تعديل</button>

</div>

</form>



</div>
</div>

</div>
</div>
<br><br>
</div>


            </div>
        </div>




    @endsection

