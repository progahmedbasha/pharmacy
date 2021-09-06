@extends('admin.layouts.header')

@section('content')

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
                                            <li><span class="bread-blod">{{ __('customer.cus_edit_info') }}</span>
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
<form action="{{route('edit_customer')}}"  method="post">
@csrf
<div class="row">
<input type="hidden" class="form-control" name="cus_id" value="{{$cusdetail->id}}">
<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('customer.cus_name_en') }}</label>
      <input type="text" class="form-control" name="cus_name_en" value="{{$cusdetail->name_en}}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('customer.cus_name_ar') }}</label>
      <input type="text" class="form-control" name="cus_name_ar" value="{{$cusdetail->name_ar}}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('customer.phone') }} </label>
      <input type="text" class="form-control" name="cus_phone" value="{{$cusdetail->phone}}"required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('customer.cus_account_num') }}</label>
      <input type="text" class="form-control"  name="cus_acc_no" value="{{$cusdetail->tree->id_code}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('customer.address') }}</label>
      <input type="text" class="form-control" name="cus_address" value="{{$cusdetail->address}}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('customer.city') }}</label>
      <input type="text" class="form-control" name="cus_city" value="{{$cusdetail->city}}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('customer.area') }}</label>
      <input type="text" class="form-control" name="cus_area" value="{{$cusdetail->area}}" required>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('customer.email') }}</label>
      <input type="email" class="form-control" name="cus_email" value="{{$cusdetail->email}}" required>
    </div>
</div>



@if($cusdetail->type == 1)
<div id="com_info">
<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('customer.comp_name_en') }}</label>
      <input type="text" class="form-control" value="{{$cusdetail->company->company_name_en}}" name="com_name_en">
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('customer.comp_name_ar') }}</label>
      <input type="text" class="form-control" value="{{$cusdetail->company->company_name_ar}}" name="com_name_ar">
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('customer.credit_limit') }}</label>
      <input type="text" class="form-control" value="{{$cusdetail->company->credit_limit}}" name="com_credit_limit">
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('customer.credit_duration') }}</label>
      <input type="text" class="form-control" value="{{$cusdetail->company->credit_duration}}"  name="com_credit_duration">
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('customer.current_balance') }}</label>
      <input type="text" class="form-control" value="{{$cusdetail->company->current_balance}}" name="com_current_balance">
    </div>
</div>
</div>
@endif

</div>

<div class="row">
   <div class="col-md-4">
      <button type="submit" class="btn btn-primary">{{ __('customer.edit_info') }}</button>
    </div>
</div>

  </form>
</div>
</div>

            </div>
        </div>
    @endsection

    