@extends('admin.layouts.header')

@section('content')

  </style>

     
        <div class="analytics-sparkle-area">
            <div class="container-fluid">
			<br><br><br>
<div class="panel panel-default">
  
  <div class="panel-heading">
     {{ __('supplier.supp_info') }}:
  </div>

  <div class="panel-body">

    <div class="row">
<div class="col-md-6">
    <a href="{{url('editsupplier')}}/{{$supdetail->id}}" class="btn btn-info">
             <i class="fa fa-edit" aria-hidden="true"></i>{{ __('supplier.edit_info') }}</a> 
          </div>

          <div class="col-md-6" style="text-align:left;">
            
            @if($supdetail->isActive != 2)
            <a href="{{url('supplier_activation')}}/{{$supdetail->id}}/2" class="btn btn-warning">
            <i class="fa fa-minus-circle" aria-hidden="true"></i> {{ __('supplier.suspend') }}</a> 
            @endif
            @if($supdetail->isActive != 1)
            <a href="{{url('supplier_activation')}}/{{$supdetail->id}}/1" class="btn btn-success">
            <i class="fa fa-check" aria-hidden="true"></i> {{ __('supplier.activate') }}</a> 
            @endif
            @if($supdetail->isActive != 3)
            <a href="{{url('supplier_activation')}}/{{$supdetail->id}}/3" class="btn btn-danger">
            <i class="fa fa-ban" aria-hidden="true"></i> {{ __('supplier.blocking') }}</a> 
            @endif 

            (<span>{{ __('supplier.status') }}</span>:&nbsp;{{$supdetail->activation->activation}})
          </div>
        </div>
        <hr>
<form action="{{route('add_new_supplier')}}"  method="post">
@csrf
<div class="row">

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('supplier.supp_name_en') }}</label>
      <input type="text" class="form-control" value="{{$supdetail->name_en}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('supplier.supp_name_ar') }}</label>
      <input type="text" class="form-control" value="{{$supdetail->name_ar}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('supplier.phone') }}</label>
      <input type="text" class="form-control" value="{{$supdetail->phone}}" disabled>
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
      <input type="text" class="form-control" value="{{$supdetail->address}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('supplier.city') }}</label>
      <input type="text" class="form-control" value="{{$supdetail->city}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('supplier.area') }}</label>
      <input type="text" class="form-control" value="{{$supdetail->area}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('supplier.email') }}</label>
      <input type="email" class="form-control" value="{{$supdetail->email}}" disabled>
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
      <input type="text" class="form-control" value="{{$supdetail->company->company_name_en}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('supplier.comp_name_ar') }}</label>
      <input type="text" class="form-control" value="{{$supdetail->company->company_name_ar}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="email">{{ __('supplier.credit_limit') }}</label>
      <input type="text" class="form-control" value="{{$supdetail->company->credit_limit}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('supplier.credit_duration') }}</label>
      <input type="text" class="form-control" value="{{$supdetail->company->credit_duration}}" disabled>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
      <label for="pwd">{{ __('supplier.current_balance') }}</label>
      <input type="text" class="form-control" value="{{$supdetail->company->current_balance}}" disabled>
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

    