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
                                            <li><span class="bread-blod">{{ __('supplier.supp_edit_info') }}</span>
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
<form action="{{route('edit_supplier')}}"  method="post">
@csrf
<div class="row">

<input type="hidden" class="form-control" name="sup_id" value="{{$supdetail->id}}">

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('supplier.supp_name_en') }}</label>
      <input type="text" class="form-control" name="sup_name_en" value="{{$supdetail->name_en}}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('supplier.supp_name_ar') }}</label>
      <input type="text" class="form-control" name="sup_name_ar" value="{{$supdetail->name_ar}}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('supplier.phone') }}</label>
      <input type="text" class="form-control" name="sup_phone" value="{{$supdetail->phone}}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('supplier.supp_account_num') }}</label>
      <input type="text" class="form-control" name="sup_acc_no" value="{{$supdetail->tree->id_code}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('supplier.address') }}</label>
      <input type="text" class="form-control" name="sup_address" value="{{$supdetail->address}}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('supplier.city') }}</label>
      <input type="text" class="form-control" name="sup_city" value="{{$supdetail->city}}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('supplier.area') }}</label>
      <input type="text" class="form-control" name="sup_area" value="{{$supdetail->area}}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('supplier.email') }}</label>
      <input type="email" class="form-control" name="sup_email" value="{{$supdetail->email}}" required>
    </div>
</div>

<div class="col-md-4">
   <div class="form-group">
      <label for="pwd">{{ __('supplier.supp_type') }}</label>
      @if($supdetail->type == 0)
      <input type="text" class="form-control" value="{{ __('supplier.cash') }}" disabled>
      @else
      <input type="text" class="form-control" value="{{ __('supplier.postponed') }}" disabled>
      @endif
    </div>
</div>

@if($supdetail->type == 1)
<div id="com_info">
<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('supplier.comp_name_en') }}</label>
      <input type="text" class="form-control" name="com_name_en" value="{{$supdetail->company->company_name_en}}">
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('supplier.comp_name_ar') }}</label>
      <input type="text" class="form-control" name="com_name_ar" value="{{$supdetail->company->company_name_ar}}">
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('supplier.credit_limit') }}</label>
      <input type="text" class="form-control" name="com_credit_limit" value="{{$supdetail->company->credit_limit}}">
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('supplier.credit_duration') }}</label>
      <input type="text" class="form-control" name="com_credit_duration" value="{{$supdetail->company->credit_duration}}">
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('supplier.current_balance') }}</label>
      <input type="text" class="form-control" name="com_current_balance" value="{{$supdetail->company->current_balance}}">
    </div>
</div>
</div>
@endif
</div>

<div class="col-md-4">
    <button type="submit" class="btn btn-primary">{{ __('supplier.edit_info') }}</button>
    </div>

  </form>
</div>
</div>

            </div>
        </div>

<script>
 
</script>
    @endsection

    