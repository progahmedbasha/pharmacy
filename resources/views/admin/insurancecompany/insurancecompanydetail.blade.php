@extends('admin.layouts.header')

@section('content')
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
                                            <li><span class="bread-blod">{{ __('insurance.comp_info') }}</span>
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

<div class="row">


  <div class="col-sm-4">
    <div class="form-group">
      <label>{{ __('insurance.comp_name_en') }}</label>
      <input type="text" class="form-control" value="{{$compdetail->company_name_en}}" disabled>
    </div>
  </div>

  <div class="col-sm-4">
    <div class="form-group">
      <label>{{ __('insurance.comp_name_ar') }}</label>
      <input type="text" class="form-control" value="{{$compdetail->company_name_ar}}" disabled>
    </div>
  </div>

   <div class="col-sm-4">
    <div class="form-group">
      <label>{{ __('insurance.phone') }}</label>
      <input type="text" class="form-control"   value="{{$compdetail->phone1}}" disabled>
    </div>
 </div>
  
  <div class="col-sm-4">
    <div class="form-group">
      <label>{{ __('insurance.phone1') }}</label>
      <input type="text" class="form-control" value="{{$compdetail->phone2}}" disabled>
    </div>
  </div>
  
  <div class="col-sm-4">
    <div class="form-group">
      <label>{{ __('insurance.email') }}</label>
      <input type="text" class="form-control" value="{{$compdetail->email}}" disabled>
    </div>
  </div>


  <div class="col-sm-4">

    <div class="form-group">
      <label>{{ __('insurance.comp_responsible_en') }}</label>
      <input type="text" class="form-control"  value="{{$compdetail->responsible_name_en}}" disabled>
    </div>
  </div>

  <div class="col-sm-4">

    <div class="form-group">
      <label>{{ __('insurance.comp_responsible_ar') }}</label>
      <input type="text" class="form-control"  value="{{$compdetail->responsible_name_ar}}" disabled>
    </div>
  </div>
  
  <div class="col-sm-4">

    <div class="form-group">
      <label>{{ __('insurance.commercial_num') }}</label>
      <input type="text" class="form-control"  value="{{$compdetail->cr_number}}" disabled>
</div>
</div>
  <div class="col-sm-4">
    <div class="form-group">
      <label>{{ __('insurance.tax_num') }}</label>
      <input type="text" class="form-control"  value="{{$compdetail->tax_number}}" disabled>
    </div>
  </div>

</div><!-------row----->

<br><br>

<!-- Button to Open the Modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
  {{ __('insurance.add_class') }}
</button>
<br><br>
<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="text-align:center;">{{ __('insurance.add_class') }}</h4>
      </div>

      <!-- Modal body -->
      <div class="modal-body">

<form action="{{route('add_new_class')}}" method="post">
@csrf

      <input type="hidden" class="form-control"  value="{{$compdetail->id}}" name="comp_id" required>

        <div class="form-group">
      <label>{{ __('insurance.class') }}</label>
      <input type="text" class="form-control"  name="insurancecom_classification" required>
    </div>
     

      <div class="form-group">
  <label>{{ __('insurance.discount_percentage') }}</label>
      <input type="text" class="form-control"  name="insurancecom_discount" required>
  </div>


<div class="form-group">
  <label>{{ __('insurance.fixed_amount') }}</label>
      <input type="text" class="form-control" name="insurancecom_fixedamount" required>
    </div>


      <div class="form-group">
  <label>{{ __('insurance.max_amount') }}</label>
      <input type="text" class="form-control"   name="insurancecom_maxlimit" required>
    </div>

<button type="submit" class="btn btn-primary" >{{ __('insurance.save') }}</button>
</form>

    </div>
  </div>
</div>
</div>


<table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>{{ __('insurance.class') }}</th>
        <th>{{ __('insurance.discount_percentage') }}</th>
        <th>{{ __('insurance.fixed_amount') }}</th>
        <th>{{ __('insurance.max_amount') }}</th>
        <th>{{ __('insurance.settings') }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach($compdetail->classes as $index=>$value)
      <tr>
        <td>{{$index+1}}</td>
        <td>{{$value->class_name}}</td>
        <td>{{$value->discount_percentage}}</td>
        <td>{{$value->fixed_amount}}</td>
        <td>{{$value->max_amount}}</td>
        <td>

          <!-- Button to Open the Modal -->
<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal{{$index}}">
  <i class="fa fa-edit"></i>
</button>
<br><br>
<!-- The Modal -->
<div class="modal" id="myModal{{$index}}">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="text-align:center;">{{ __('insurance.edit_class') }}</h4>
      </div>

      <!-- Modal body -->
      <div class="modal-body">

<form action="{{route('edit_class')}}" method="post">
@csrf

      <input type="hidden" class="form-control"  value="{{$value->id}}" name="class_id" required>

        <div class="form-group">
      <label>{{ __('insurance.class') }}</label>
      <input type="text" class="form-control"  value="{{$value->class_name}}" name="insurancecom_classification" required>
    </div>
     

      <div class="form-group">
  <label>{{ __('insurance.discount_percentage') }}</label>
      <input type="text" class="form-control" value="{{$value->discount_percentage}}" name="insurancecom_discount" required>
  </div>


<div class="form-group">
  <label>{{ __('insurance.fixed_amount') }}</label>
      <input type="text" class="form-control" value="{{$value->fixed_amount}}" name="insurancecom_fixedamount" required>
    </div>


      <div class="form-group">
  <label>{{ __('insurance.max_amount') }}</label>
      <input type="text" class="form-control"  value="{{$value->max_amount}}" name="insurancecom_maxlimit" required>
    </div>

<button type="submit" class="btn btn-primary" >{{ __('insurance.save') }}</button>
</form>

    </div>
  </div>
</div>
</div>


        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

</div>
</div>

</div>
</div>
<br><br>
</div>


 @endsection