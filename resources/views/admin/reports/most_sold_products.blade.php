@extends('admin.layouts.header')

@section('content')

     
        <div class="analytics-sparkle-area">
            <div class="container-fluid">
<br>			
      

      <iframe id="iframe" src="" style="display:none;"></iframe>

			<div class="row">
		
			</div>
<br>

<div class="panel panel-default">
  <div class="panel-body">

  	<div class="row">
  	

<div class="col-md-2">  
<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">عدد الصفوف : {{$paginationVal}}
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a  href="{{url('MostSoldItemsReport')}}/10">10</a></li>
    <li><a  href="{{url('MostSoldItemsReport')}}/25">25</a></li>
    <li><a  href="{{url('MostSoldItemsReport')}}/50">50</a></li>
    <li><a  href="{{url('MostSoldItemsReport')}}/100">100</a></li>
  </ul>
</div>
</div>
<div class="col-md-2">
<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">رقم الصفحة : {{$items->currentPage()}}
  <span class="caret"></span></button>
  <ul class="dropdown-menu" style="overflow-y: scroll;height:200px;">
  	@for($i=1; $i<=$items->lastPage();$i++)
    <li><a  href="{{url('MostSoldItemsReport')}}/{{$paginationVal}}?page={{$i}}">{{$i}}</a></li>
    @endfor
  </ul>
</div>
</div>
<div class="col-md-4">
      <form method="get" class="form-inline" action="{{url('MostSoldItemsReport')}}/{{$paginationVal}}">
  	 من:&nbsp;<input  name="date_from" type="date" required><br>
  	 إلي: <input  name="date_to" type="date" required>
     <button type="submit">بحث</button>
   </form>
</div>
</div>
<br>

<div class="table-responsive">
<table class="table table-bordered">
    <thead>
      <tr>
        <th>إسم المنتج</th>
        <th>السعر</th>
		<th>عدد مرات البيع</th>
		
      </tr>
    </thead>
    <tbody>
     @foreach($items as $index=>$value)
      <tr>
        <td>{{$value->item->name_ar}}</td>
        <td>{{$value->price}}</td>
		<td>{{$value->items_count}}</td>
		
      </tr>
      @endforeach
    </tbody>
  </table>
  
  
</div>
</div>
</div>
            </div>
        </div>

<script type="text/javascript">
  function openmodle(url){
    document.getElementById("iframe").src=url;
  }
</script>


    @endsection

    