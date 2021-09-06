@extends('admin.layouts.header')

@section('content')

<style>
#com_info{
display:none;
}
  </style>


        <div class="analytics-sparkle-area">
            <div class="container-fluid">
			<br>

<div class="panel panel-default">
  <div class="panel-heading">{{ __('doctor.add_doc') }}</div>
  <div class="panel-body">
<form action="{{route('add_new_doctor')}}"  method="post" enctype="multipart/form-data">
@csrf
<div class="row">

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('doctor.doc_name_en') }}</label>
      <input type="text" class="form-control" name="doc_name_en" value="{{ old('doc_name_en') }}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('doctor.doc_name_ar') }}</label>
      <input type="text" class="form-control" name="doc_name_ar" value="{{ old('doc_name_ar') }}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('doctor.phone') }}</label>
      <input type="text" class="form-control" name="doc_phone" value="{{ old('doc_phone') }}" required>
        @error('doc_phone')
        {{$message}}
        @enderror
    </div>
</div>


<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('doctor.email') }}</label>
      <input type="email" class="form-control" name="doc_email" value="{{ old('doc_email') }}" required>
        @error('doc_email')
        {{$message}}
        @enderror
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('doctor.clinic_type') }}</label>
      <input type="text" class="form-control" name="doc_clinic_type" value="{{ old('doc_clinic_type') }}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('doctor.signature') }}</label>
      <input type="file" class="form-control dropify" name="signature" value="{{ old('signature') }}" required>
    </div>
</div>

<div class="col-md-12">
    <button type="submit" class="btn btn-primary">{{ __('doctor.save') }}</button>
    </div>

  </form>
</div>
</div>

            </div>
        </div>

<script>
  function company_info_disable(){
document.getElementById("com_info").style.display = "none";
}

function company_info_enable(){
document.getElementById("com_info").style.display = "block";
}
</script>
    @endsection

