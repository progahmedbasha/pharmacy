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
                                            <li><span class="bread-blod">إعدادات الضرائب</span>
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
  <h4>ضريبة المشتريات</h4>
  <hr>
  
<form action="{{route('update_tax')}}"  method="post">
@csrf
<input type="hidden" class="form-control" name="tax_id" value="{{$purchase_tax->id}}" required>

<div class="row">
<div class="col-md-4">
    <div class="form-group">
      <label for="email">نسبة الضريبة %</label>
      <input type="text" class="form-control" name="tax_percentage" value="{{$purchase_tax->tax_value}}" required>
    </div>
</div>
</div>

<div class="row">
<div class="col-md-4">
        <div class="form-group">
      <label for="pwd">نوع الضريبة</label>
        <div class="radio">
		<label><input type="radio" name="tax_type" value="0" {{($purchase_tax->tax_type == 0) ? 'checked' : '' }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;غير شامل</label>
  <label><input type="radio" name="tax_type" value="1"  {{($purchase_tax->tax_type == 1) ? 'checked' : '' }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;شامل</label>
</div>
    </div>
</div>
</div>

<div class="row">
<div class="col-md-12">
    <button type="submit" class="btn btn-primary">حفظ</button>
    </div>
 </div>
  </form>
</div>
</div>


<div class="panel panel-default">
  <div class="panel-body">
  <h4>ضريبة المبيعات</h4>
  <hr>
  
<form action="{{route('update_tax')}}"  method="post">
@csrf
<input type="hidden" class="form-control" name="tax_id" value="{{$sale_tax->id}}" required>
<div class="row">
<div class="col-md-4">
    <div class="form-group">
      <label for="email">نسبة الضريبة %</label>
      <input type="text" class="form-control" name="tax_percentage" value="{{$sale_tax->tax_value}}" required>
    </div>
</div>
</div>

<div class="row">
<div class="col-md-4">
        <div class="form-group">
      <label for="pwd">نوع الضريبة</label>
        <div class="radio">
		<label><input type="radio" name="tax_type" value="0" {{($sale_tax->tax_type == 0) ? 'checked' : '' }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;غير شامل</label>
  <label><input type="radio" name="tax_type" value="1"  {{($sale_tax->tax_type == 1) ? 'checked' : '' }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;شامل</label>
</div>
    </div>
</div>
</div>

<div class="row">
<div class="col-md-12">
    <button type="submit" class="btn btn-primary">حفظ</button>
    </div>
</div>
  </form>
</div>
</div>

            </div>
        </div>


</script>
    @endsection

    