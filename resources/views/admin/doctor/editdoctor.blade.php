@extends('admin.layouts.header')

@section('content')

<style>

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
                                            <li><span class="bread-blod">{{ __('doctor.doc_edit_info') }}</span>
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
<form action="{{route('edit_doctor')}}"  method="post" enctype="multipart/form-data">
@csrf
<div class="row">

<input type="hidden" class="form-control" name="doc_id" value="{{$docdetail->id}}">

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('doctor.doc_name_en') }}</label>
      <input type="text" class="form-control" name="doc_name_en" value="{{$docdetail->name_en}}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('doctor.doc_name_ar') }}</label>
      <input type="text" class="form-control" name="doc_name_ar" value="{{$docdetail->name_ar}}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('doctor.phone') }}</label>
      <input type="text" class="form-control" name="doc_phone" value="{{$docdetail->phone}}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('doctor.email') }}</label>
      <input type="email" class="form-control" name="doc_email" value="{{$docdetail->email}}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('doctor.clinic_type') }}</label>
      <input type="text" class="form-control" name="doc_clinic_type" value="{{$docdetail->clinic_type}}" required>
    </div>
</div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="email">{{ __('doctor.signature') }}</label>
            <input type="file" class="form-control dropify" name="signature" value="{{ old('signature') }}" required>
        </div>
    </div>

</div>

<div class="col-md-4">
    <button type="submit" class="btn btn-primary">{{ __('doctor.edit_info') }}</button>
    </div>

  </form>
</div>
</div>

            </div>
        </div>

<script>

</script>
    @endsection

