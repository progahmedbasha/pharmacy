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
  <div class="panel-heading">{{ __('supplier.add_supp') }}</div>
  <div class="panel-body">
<form action="{{route('add_new_supplier')}}"  method="post">
@csrf
<div class="row">

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('supplier.supp_name_en') }}</label>
      <input type="text" class="form-control" name="sup_name_en" value="{{ old('sup_name_en') }}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('supplier.supp_name_ar') }}</label>
      <input type="text" class="form-control" name="sup_name_ar" value="{{ old('sup_name_ar') }}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('supplier.phone') }}</label>
      <input type="text" class="form-control" name="sup_phone" value="{{ old('sup_phone') }}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('supplier.address') }}</label>
      <input type="text" class="form-control" name="sup_address" value="{{ old('sup_address') }}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('supplier.city') }}</label>
      <input type="text" class="form-control" name="sup_city" value="{{ old('sup_city') }}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('supplier.area') }}</label>
      <input type="text" class="form-control" name="sup_area" value="{{ old('sup_area') }}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('supplier.email') }}</label>
      <input type="email" class="form-control" name="sup_email" value="{{ old('sup_email') }}" required>
    </div>
</div>

<div class="col-md-4">
        <div class="form-group">
      <label for="pwd">{{ __('supplier.sup_classification') }}</label>
        <div class="radio">
  <label><input type="radio" name="sup_classify" value="0"  {{ (old('sup_classify') == 0) ? 'checked' : '' }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ __('supplier.sup_local') }}</label>
  <label><input type="radio" name="sup_classify" value="1" {{ (old('sup_classify') == 1) ? 'checked' : '' }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ __('supplier.sub_international') }}</label>
</div>
    </div>
</div>

<div class="col-md-12">
        <div class="form-group">
      <label for="pwd">{{ __('supplier.supp_type') }}</label>
        <div class="radio">
  <label><input type="radio" name="sup_type" value="0" onclick="company_info_disable()" {{ (old('sup_type') == 0) ? 'checked' : '' }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ __('supplier.cash') }}</label>
  <label><input type="radio" name="sup_type" value="1" onclick="company_info_enable()" {{ (old('sup_type') == 1) ? 'checked' : '' }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ __('supplier.postponed') }}</label>
</div>
    </div>
</div>




@if(old('sup_type') == 1)
<div>
@else
<div id="com_info">
@endif
<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('supplier.comp_name_en') }}</label>
      <input type="text" class="form-control" name="com_name_en" value="{{ old('com_name_en') }}">
         @error('com_name_en')
    <div class="alert alert-danger">{{ $message }}</div>
   @enderror
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('supplier.comp_name_ar') }}</label>
      <input type="text" class="form-control" name="com_name_ar" value="{{ old('com_name_ar') }}">
         @error('com_name_ar')
    <div class="alert alert-danger">{{ $message }}</div>
   @enderror
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('supplier.credit_limit') }}</label>
      <input type="text" class="form-control" name="com_credit_limit" value="{{ old('com_credit_limit') }}">
         @error('com_credit_limit')
    <div class="alert alert-danger">{{ $message }}</div>
   @enderror
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('supplier.credit_duration') }}</label>
      <input type="text" class="form-control" name="com_credit_duration" value="{{ old('com_credit_duration') }}">
         @error('com_credit_duration')
    <div class="alert alert-danger">{{ $message }}</div>
   @enderror
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('supplier.current_balance') }}</label>
      <input type="text" class="form-control" name="com_current_balance" value="{{ old('com_current_balance') }}">
         @error('com_current_balance')
    <div class="alert alert-danger">{{ $message }}</div>
   @enderror
    </div>
</div>
</div>
</div>

<div class="col-md-12">
    <button type="submit" class="btn btn-primary">{{ __('supplier.save') }}</button>
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

    