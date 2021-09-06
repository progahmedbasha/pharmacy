@extends('admin.layouts.header')

@section('content')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>


<style>
#com_info{
display:none;
}
  </style>

     
        <div class="analytics-sparkle-area">
            <div class="container-fluid">

			<br><br>

<div class="panel panel-default">
    <div class="panel-heading">اضافة خزنة / بنك</div>
  <div class="panel-body">
<form action="{{route('add_new_safe_bank')}}"  method="post">
@csrf
<div class="row">

<div class="col-md-12">
    <div class="form-group">
      <label for="email">الاسم en</label>
      <input type="text" class="form-control" name="treasury_name_en" required>
    </div>
</div>

<div class="col-md-12">
    <div class="form-group">
      <label for="email">الاسم ar</label>
      <input type="text" class="form-control" name="treasury_name_ar" required>
    </div>
</div>

<div class="col-md-12">
    <div class="form-group">
     <label for="email">النوع</label>
<div class="radio">
  <label><input type="radio" name="treasury_type" value="0" checked>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;خزنة</label>
  <label><input type="radio" name="treasury_type" value="1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;بنك</label>
  <label>
</div>
    </div>
</div>


<div class="col-md-12">
    <div class="form-group">
      <label for="pwd">الوصف</label>
      <textarea rows="4" class="form-control" name="treasury_description" ></textarea>
    </div>
</div>


</div>




<div class="row">
   <div class="col-md-12">
      <button type="submit" class="btn btn-primary">حفظ</button>
    </div>
</div>

  </form>
</div>
</div>

            </div>
        </div>


    @endsection

    