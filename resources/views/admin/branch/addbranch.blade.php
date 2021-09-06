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
  <div class="panel-heading">{{ __('branch.add_branch') }}</div>
  <div class="panel-body">
<form action="{{route('add_new_branch')}}"  method="post">
@csrf
<div class="row">

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('branch.branch_name_en') }}</label>
      <input type="text" class="form-control" name="branch_name_en" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('branch.branch_name_ar') }}</label>
      <input type="text" class="form-control" name="branch_name_ar" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('branch.employee') }}</label>
      <select class="form-control" name="branch_employee" >
        <option disabled selected>{{ __('branch.choose_employee') }}</option>
        @foreach($employees as $value)
          <option value="{{$value->id}}">{{$value->name}}</option>
        @endforeach
  </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('branch.country') }}</label>
      <select class="form-control" name="branch_country" >
        <option disabled selected>{{ __('branch.choose_country') }}</option>
        @foreach($countries as $value)
          <option value="{{$value->id}}">{{$value->country}}</option>
        @endforeach
  </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('branch.city') }}</label>
      <input type="text" class="form-control" name="branch_city" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('branch.address') }}</label>
      <input type="text" class="form-control" name="branch_address" required>
    </div>
</div>


<div class="col-md-12">
    <button type="submit" class="btn btn-primary">{{ __('branch.save') }}</button>
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

    