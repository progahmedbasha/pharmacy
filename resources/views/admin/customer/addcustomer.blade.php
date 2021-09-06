@extends('admin.layouts.header')

@section('content')


<style>
#com_info{
display:none;
}

#insurance_info{
display:none;
}
  </style>

     
        <div class="analytics-sparkle-area">
            <div class="container-fluid">
	
<br>
<div class="panel panel-default">
    <div class="panel-heading">{{ __('customer.add_cus') }}</div>
  <div class="panel-body">
<form action="{{route('add_new_customer')}}"  method="post">
@csrf
<div class="row">

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('customer.cus_name_en') }}</label>
      <input type="text" class="form-control" name="cus_name_en" value="{{ old('cus_name_en') }}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('customer.cus_name_ar') }}</label>
      <input type="text" class="form-control" name="cus_name_ar" value="{{ old('cus_name_ar') }}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('customer.phone') }}</label>
      <input type="text" class="form-control" name="cus_phone" value="{{ old('cus_phone') }}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('customer.address') }}</label>
      <input type="text" class="form-control" name="cus_address" value="{{ old('cus_address') }}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('customer.city') }}</label>
      <input type="text" class="form-control" name="cus_city" value="{{ old('cus_city') }}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('customer.area') }}</label>
      <input type="text" class="form-control" name="cus_area" value="{{ old('cus_area') }}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('customer.email') }}</label>
      <input type="email" class="form-control" name="cus_email" value="{{ old('cus_email') }}" required>
    </div>
</div>

<div class="col-md-12">

    <div class="form-group">
      <label for="pwd">{{ __('customer.cus_type') }}</label>
        <div class="radio">
  <label><input type="radio" name="cus_type" value="0" onclick="company_info_disable()" {{ (old('cus_type') == 0) ? 'checked' : '' }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ __('customer.individual') }}</label>
  <label><input type="radio" name="cus_type" value="1" onclick="company_info_enable()" {{ (old('cus_type') == 1) ? 'checked' : '' }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ __('customer.company') }}</label>
</div>
    </div>
</div>

@if(old('cus_type') == 1)
<div>
@else
<div id="com_info">
@endif
<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('customer.comp_name_en') }}</label>
      <input type="text" class="form-control" name="com_name_en" value="{{ old('com_name_en') }}">
      @error('com_name_en')
    <div class="alert alert-danger">{{ $message }}</div>
   @enderror
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('customer.comp_name_ar') }}</label>
      <input type="text" class="form-control" name="com_name_ar" value="{{ old('com_name_ar') }}">
      @error('com_name_ar')
    <div class="alert alert-danger">{{ $message }}</div>
   @enderror
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('customer.credit_limit') }}</label>
      <input type="text" class="form-control" name="com_credit_limit" value="{{ old('com_credit_limit') }}">
      @error('com_credit_limit')
    <div class="alert alert-danger">{{ $message }}</div>
   @enderror
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('customer.credit_duration') }}</label>
      <input type="text" class="form-control" name="com_credit_duration" value="{{ old('com_credit_duration') }}">
      @error('com_credit_duration')
    <div class="alert alert-danger">{{ $message }}</div>
   @enderror
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('customer.current_balance') }}</label>
      <input type="text" class="form-control" name="com_current_balance" value="{{ old('com_current_balance') }}">
      @error('com_current_balance')
    <div class="alert alert-danger">{{ $message }}</div>
   @enderror
    </div>
</div>
</div>

</div>

<div class="row">
   <div class="col-md-12">
      <div class="form-group form-check">
      <label class="form-check-label">
        <input class="form-check-input" type="checkbox" id="insurance_val" name="insurance_val" value="1" onclick="enable_disable_insurance()" {{ (old('active_multi_val') == 1) ? 'checked' : '' }}>&nbsp;&nbsp;&nbsp;&nbsp;
          {{ __('customer.insur_belong') }}
      </label>
    </div>
    </div>
</div>

 <div id="insurance_info">
<div class="row">
   <div class="col-md-4">
<div class="form-group">
  <label for="sel1">{{ __('customer.insur_comp') }}:</label>
  <select class="form-control" id="insurance" onChange="main_insurance_val()">
    <option disabled selected>{{ __('customer.choose_insur') }}</option>
    @foreach($insurance as $value)
    <option value="{{$value->classes}}">{{$value->company_name}}</option>
    @endforeach
  </select>
</div>
</div>

<div class="col-md-4">
<div class="form-group">
  <label for="sel1">{{ __('customer.class') }}:</label>
  <select class="form-control" id="classes" name="class_id">
   <!-- <option disabled selected>إختر التصنيف</option>-->
  </select>
</div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('customer.card_num') }}</label>
      <input type="text" class="form-control" name="card_number">
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('customer.expire_date') }}</label>
      <input type="date" class="form-control" name="expire_date">
    </div>
</div>

 </div>
</div>

<div class="row">
   <div class="col-md-12">
      <button type="submit" class="btn btn-primary">{{ __('customer.save') }}</button>
    </div>
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


function enable_disable_insurance(){
   var checkBox = document.getElementById("insurance_val");
  // If the checkbox is checked, display the output text
  if (checkBox.checked == true){
   document.getElementById("insurance_info").style.display = "block";
  } else {
    document.getElementById("insurance_info").style.display = "none";
  }
}
</script>

<script>
  function main_insurance_val() {

    var d = JSON.parse(document.getElementById("insurance").value);
    //document.getElementById("lis_val").value = d;
    
    //console.log(d);

    var catOptions = "";
    catOptions += "<option value='' disabled selected=''>{{ __('customer.choose_class') }}</option>";
     if (d.length == 0) {
      //document.getElementById("subcat").innerHTML = "<option></option>";
      }else {
        var name = d.map(({class_name}) => class_name);
        var id = d.map(({id}) => id);
        var amount = d.map(({max_amount}) => max_amount);
        for (x in name) {
          catOptions += "<option value ='" + id[x] +"'>" + name[x] + "</option>";
        }
       // console.log("ddd",d);
      }
      document.getElementById("classes").innerHTML = catOptions;
  }
</script>
    @endsection

    