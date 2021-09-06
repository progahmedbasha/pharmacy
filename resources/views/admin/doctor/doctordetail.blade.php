@extends('admin.layouts.header')

@section('content')

  </style>

     
        <div class="analytics-sparkle-area">
            <div class="container-fluid">
			<br><br><br>
<div class="panel panel-default">
  
  <div class="panel-heading">
     {{ __('doctor.doc_info') }}:
  </div>

  <div class="panel-body">

    <div class="row">
<div class="col-md-6">
    <a href="{{url('editdoctor')}}/{{$docdetail->id}}" class="btn btn-info">
             <i class="fa fa-edit" aria-hidden="true"></i>{{ __('doctor.edit_info') }}</a> 
          </div>

        <!--  <div class="col-md-6" style="text-align:left;">
            
            @if($docdetail->isActive != 2)
            <a href="{{url('doctor_activation')}}/{{$docdetail->id}}/2" class="btn btn-warning">
            <i class="fa fa-minus-circle" aria-hidden="true"></i> {{ __('doctor.suspend') }}</a> 
            @endif
            @if($docdetail->isActive != 1)
            <a href="{{url('doctor_activation')}}/{{$docdetail->id}}/1" class="btn btn-success">
            <i class="fa fa-check" aria-hidden="true"></i> {{ __('doctor.activate') }}</a> 
            @endif
            @if($docdetail->isActive != 3)
            <a href="{{url('doctor_activation')}}/{{$docdetail->id}}/3" class="btn btn-danger">
            <i class="fa fa-ban" aria-hidden="true"></i> {{ __('doctor.blocking') }}</a> 
            @endif 

          </div>-->
        </div>
        <hr>
<form action="{{route('add_new_doctor')}}"  method="post">
@csrf
<div class="row">

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('doctor.doc_code') }}</label>
      <input type="text" class="form-control" value="{{$docdetail->doc_code}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('doctor.doc_name_en') }}</label>
      <input type="text" class="form-control" value="{{$docdetail->name_en}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('doctor.doc_name_ar') }}</label>
      <input type="text" class="form-control" value="{{$docdetail->name_ar}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('doctor.phone') }}</label>
      <input type="text" class="form-control" value="{{$docdetail->phone}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('doctor.email') }}</label>
      <input type="email" class="form-control" value="{{$docdetail->email}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('doctor.clinic_type') }}</label>
      <input type="email" class="form-control" value="{{$docdetail->clinic_type}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('doctor.signature') }}</label>
      <img src="{{Storage::url('uploads/'.$docdetail->signature)}}" />
    </div>
</div>

</div>


  </form>
</div>
</div>

            </div>
        </div>
    @endsection

    