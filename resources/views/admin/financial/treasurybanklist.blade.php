@extends('admin.layouts.header')

@section('content')


        <div class="analytics-sparkle-area">
            <div class="container-fluid">
			<br>
			خزائن وحسابات بنكية: <a href="{{url('addtreasurybank')}}" class="btn btn-success">إنشاء  خزائن وحسابات بنكية </a>
			<br><br>

<br>

<div class="panel panel-default">
  <div class="panel-body">
        <div class="row">
    <div class="col-md-6">
      <form method="get" class="form-inline" action="{{url('treasurybanklist')}}/{{$paginationVal}}">
          <input class="form-control input-lg" name="search" type="text" >
          <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i></button>
          <a href="{{url('treasurybanklist')}}/{{$paginationVal}}" class="btn btn-danger" style="margin-top:0px;"><i class="fa fa-times"></i></a>
      </form>
</div>
      <div class="row">
<div class="col-md-2">
<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">عدد الصفوف : {{$paginationVal}}
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a  href="{{url('treasurybanklist')}}/10">10</a></li>
    <li><a  href="{{url('treasurybanklist')}}/25">25</a></li>
    <li><a  href="{{url('treasurybanklist')}}/50">50</a></li>
    <li><a  href="{{url('treasurybanklist')}}/100">100</a></li>
  </ul>
</div>
</div>
<div class="col-md-2">
<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">رقم الصفحة : {{$safe_banks->currentPage()}}
  <span class="caret"></span></button>
  <ul class="dropdown-menu" style="overflow-y: scroll;height:200px;">
    @for($i=1; $i<=$safe_banks->lastPage();$i++)
    <li><a  href="{{url('treasurybanklist')}}/{{$paginationVal}}?page={{$i}}">{{$i}}</a></li>
    @endfor
  </ul>
</div>
</div>
</div>
<br>
<div class="table-responsive">
<table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>رقم الحساب</th>
        <th>التاريخ</th>
        <th>الاسم(en)</th>
        <th>الاسم(ar)</th>
        <th>النوع</th>
		<th>الوصف</th>
		<th>الاجراءات</th>
      </tr>
    </thead>
    <tbody>
      @foreach($safe_banks as $index=>$value)
      <tr>
        <td>{{$index+1}}</td>
        <td>{{$value->tree->id_code ?? ''}}</td>
        <td>{{$value->created_at}}</td>
		    <td>{{$value->name_en}}</td>
        <td>{{$value->name_ar}}</td>
        @if($value->type == 0)
          <td>خزنة</td>
        @else
          <td>بنك</td>
        @endif
        <td>{{$value->description}}</td>
		    <td>-</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
</div>
</div>
            </div>
        </div>


    @endsection

