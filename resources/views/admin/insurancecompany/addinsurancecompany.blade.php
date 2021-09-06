@extends('admin.layouts.header')

@section('content')

     
        <div class="analytics-sparkle-area">
            <div class="container-fluid">
<br>
<div class="panel panel-default">
   <div class="panel-heading">{{ __('insurance.add_comp') }}</div>
  <div class="panel-body">

<form action="{{route('add_new_company')}}" method="post">
@csrf


<div class="row">


 <div class="col-sm-4">
    <div class="form-group">
      <label>{{ __('insurance.comp_name_en') }}</label>
      <input type="text" class="form-control" name="insurancecom_name_en" required>
    </div>
  </div>

  <div class="col-sm-4">
    <div class="form-group">
      <label>{{ __('insurance.comp_name_ar') }}</label>
      <input type="text" class="form-control" name="insurancecom_name_ar" required>
    </div>
  </div>

  <div class="col-sm-4">
    <div class="form-group">
      <label>{{ __('insurance.phone') }}</label>
      <input type="text" class="form-control"   name="insurancecom_phone" required>
    </div>
   </div>
  
  <div class="col-sm-4">
    <div class="form-group">
      <label>{{ __('insurance.phone1') }}</label>
      <input type="text" class="form-control" name="insurancecom_phone2">
    </div>
  </div>
  
  <div class="col-sm-4">
    <div class="form-group">
      <label>{{ __('insurance.email') }}</label>
      <input type="text" class="form-control" name="insurancecom_email" required>
    </div>

  </div>

 <div class="col-sm-4">
    <div class="form-group">
      <label>{{ __('insurance.comp_responsible_en') }}</label>
      <input type="text" class="form-control"  name="insurancecom_responsible_en" required>
    </div>
  </div>

  <div class="col-sm-4">
    <div class="form-group">
      <label>{{ __('insurance.comp_responsible_ar') }}</label>
      <input type="text" class="form-control"  name="insurancecom_responsible_ar" required>
    </div>
  </div>
  
  <div class="col-sm-4">
    <div class="form-group">
      <label>{{ __('insurance.commercial_num') }}</label>
      <input type="text" class="form-control"  name="insurancecom_commertialrecord" required>
    </div>
  </div>

  <div class="col-sm-4">
<div class="form-group">
  <label>{{ __('insurance.tax_num') }}</label>
      <input type="text" class="form-control"  name="insurancecom_tax" required>
    </div>
   </div>
  
  <div class="col-sm-4">
    <div class="form-group">
      <label>{{ __('insurance.class') }}</label>
          <input type="text" class="form-control"  name="insurancecom_classification" required>
    </div>
  </div>

   <div class="col-sm-4">
<div class="form-group">
  <label>{{ __('insurance.discount_percentage') }}</label>
      <input type="text" class="form-control"  name="insurancecom_discount" required>
  </div>

</div>

<div class="col-sm-4">
<div class="form-group">
  <label>{{ __('insurance.fixed_amount') }}</label>
      <input type="text" class="form-control" name="insurancecom_fixedamount" required>
    </div>
</div>
  
  <div class="col-sm-4">
  <div class="form-group">
    <label>{{ __('insurance.max_amount') }}</label>
      <input type="text" class="form-control"   name="insurancecom_maxlimit" required>
  </div>
</div><!-------col---->
  

<div class="col-sm-12">
<button type="submit" class="btn btn-primary" >{{ __('insurance.save') }}</button>
</div>

</div><!-------row----->

</form>

</div>
</div>

</div>
</div>
<br><br>
</div>


 @endsection