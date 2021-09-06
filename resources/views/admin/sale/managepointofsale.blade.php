@extends('admin.layouts.header')

@section('content')

     
        <div class="analytics-sparkle-area">
            <div class="container-fluid">
			<br>
			إدارة نقاط البيع: <button type="button" class="btn btn-success">إنشاء فاتورة</button>
			<br><br>
			<div class="row">
			<div class="col-md-3">
			<b>اجمالي عدد الشفتات</b> <span style="color:green;font-size:16px;">3</span>
			</div>
			<div class="col-md-3">
			<b>اجمالي مبلغ الشفتات</b> <span style="color:green;font-size:16px;">500</span>
			</div>
			<div class="col-md-3">
			<b>اجمالي النقدي</b> <span style="color:green;font-size:16px;">300</span>
			</div>
			<div class="col-md-3">
			<b>اجمالي الشبكة</b> <span style="color:green;font-size:16px;">200</span>
			</div>
			</div>
<br>
<div class="panel panel-default">
  <div class="panel-body">
<div class="table-responsive">
<table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>رقم الشيفت</th>
        <th>وقت البدء</th>
		<th>وقت الانتهاء</th>
		<th>اسم البائع</th>
		<th>الحالة</th>
		<th>اجمالي المبيعات</th>
		<th>النقدي</th>
		<th>الشبكة</th>
		<th>الاجراءات</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>24124124</td>
        <td>12/11/2020</td>
		<td>15/11/2020</td>
		<td>اشرف شبل</td>
		 <td>مغلق</td>
        <td>600</td>
        <td>400</td>
		 <td>900</td>
        <td>-</td>
      </tr>
    </tbody>
  </table>
    </div>
  </div>
  </div>
            </div>
        </div>


    @endsection

    