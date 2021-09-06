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
                                            <li><span class="bread-blod">{{ __('customer.cus_info') }}</span>
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

		   <div class="row">

<div class="col-md-6">
    <a href="{{url('editcustomer')}}/{{$cusdetail->id}}" class="btn btn-info">
            <i class="fa fa-edit" aria-hidden="true"></i>{{ __('customer.edit_info') }}</a>
</div>
                      <div class="col-md-6" style="text-align:left;">
            @if($cusdetail->isActive != 2)
            <a href="{{url('customer_activation')}}/{{$cusdetail->id}}/2" class="btn btn-warning">
            <i class="fa fa-minus-circle" aria-hidden="true"></i> {{ __('customer.suspend') }}</a>
            @endif
            @if($cusdetail->isActive != 1)
            <a href="{{url('customer_activation')}}/{{$cusdetail->id}}/1" class="btn btn-success">
            <i class="fa fa-check" aria-hidden="true"></i> {{ __('customer.activate') }}</a>
            @endif
            @if($cusdetail->isActive != 3)
            <a href="{{url('customer_activation')}}/{{$cusdetail->id}}/3" class="btn btn-danger">
            <i class="fa fa-ban" aria-hidden="true"></i> {{ __('customer.blocking') }}</a>
            @endif
<br>
            <span>{{ __('customer.status') }}</span>:&nbsp;{{$cusdetail->activation->activation}}
          </div>
</div>

<br>
<div class="panel panel-default">
  <div class="panel-body">
<form>

<div class="row">

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('customer.cus_name_en') }}</label>
      <input type="text" class="form-control" value="{{$cusdetail->name_en}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('customer.cus_name_ar') }}</label>
      <input type="text" class="form-control" value="{{$cusdetail->name_ar}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('customer.phone') }}</label>
      <input type="text" class="form-control" value="{{$cusdetail->phone}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('customer.cus_account_num') }}</label>
      <input type="text" class="form-control"  value="{{$cusdetail->tree->id_code}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('customer.address') }}</label>
      <input type="text" class="form-control" value="{{$cusdetail->address}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('customer.city') }}</label>
      <input type="text" class="form-control" value="{{$cusdetail->city}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('customer.area') }}</label>
      <input type="text" class="form-control" value="{{$cusdetail->area}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('customer.email') }}</label>
      <input type="email" class="form-control" value="{{$cusdetail->email}}" disabled>
    </div>
</div>

<div class="col-md-4">
   <div class="form-group">
      <label for="pwd">{{ __('customer.cus_type') }}</label>
      @if($cusdetail->type == 0)
      <input type="text" class="form-control" value="{{ __('customer.individual') }}" disabled>
       @else
      <input type="text" class="form-control" value="{{ __('customer.company') }}" disabled>
      @endif
    </div>
</div>
@if($cusdetail->type == 1)
        @if($cusdetail->company)
            <div id="com_info">
            <div class="col-md-4">
                <div class="form-group">
                  <label for="pwd">{{ __('customer.comp_name_en') }}</label>
                  <input type="text" class="form-control" value="@if($cusdetail->company){{$cusdetail->company->company_name_en}}@endif" disabled>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                  <label for="pwd">{{ __('customer.comp_name_ar') }}</label>
                  <input type="text" class="form-control" value="@if($cusdetail->company){{$cusdetail->company->company_name_ar}}@endif" disabled>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                  <label for="email">{{ __('customer.credit_limit') }}</label>
                  <input type="text" class="form-control" value="@if($cusdetail->company){{$cusdetail->company->credit_limit}}@endif" disabled>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                  <label for="pwd">{{ __('customer.credit_duration') }}</label>
                  <input type="text" class="form-control" value="{{$cusdetail->company->credit_duration}}" disabled>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                  <label for="pwd">{{ __('customer.current_balance') }}</label>
                  <input type="text" class="form-control" value="{{$cusdetail->company->current_balance}}" disabled>
                </div>
            </div>
            </div>
        @endif
@endif

@if($cusdetail->insurance_class != null)
<div id="com_info">
<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('customer.insur_comp') }}</label>
      <input type="text" class="form-control" value="{{$cusdetail->insurance_class->company->company_name}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('customer.class') }}</label>
      <input type="text" class="form-control" value="{{$cusdetail->insurance_class->class_name}}" disabled>
    </div>
</div>

</div>
</div>
@endif
</div>


  </form>
</div>
</div>

            </div>
        </div>


    @endsection

