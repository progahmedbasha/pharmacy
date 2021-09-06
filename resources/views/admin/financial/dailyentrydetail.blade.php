@extends('admin.layouts.header')

@section('content')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>


<style>
#com_info{
display:none;
}
  </style>
 
     
        <div class="analytics-sparkle-area">
            <div class="container-fluid">
                <br><br><br>

<div class="panel panel-default">
     <div class="panel-heading">تفاصيل القيد: 
        @if($entry->type == 1)
        <a href="{{url('/').$entry->source}}" type="button" class="btn btn-info">المصدر</a>
        @endif
        <button type="button" class="btn btn-success" onclick="openmodle()"><i class="fa fa-print" aria-hidden="true"></i> طباعة القيد</button>
        <a href="{{url()->previous()}}" type="button" class="btn btn-info">رجوع</a>
        </div>

          <iframe id="iframe" src="" style="display:none;"></iframe>

  <div class="panel-body">
     

<div class="row">

<div class="col-md-2">
    <div class="form-group">
      <label for="email">رقم القيد</label>
      <input type="text" class="form-control" value="{{$entry->id}}" disabled>
    </div>
</div>

<div class="col-md-5">
    <div class="form-group">
      <label for="email">عنوان القيد</label>
      <input type="text" class="form-control" value="{{$entry->title}}" disabled>
    </div>
</div>

<div class="col-md-5">
    <div class="form-group">
      <label for="email">التاريخ</label>
      <input type="date" class="form-control" value="{{$entry->date}}" disabled>
    </div>
</div>

<div class="col-md-12">
    <div class="form-group">
      <label for="pwd">الوصف</label>
      <textarea rows="4" class="form-control" disabled>{{$entry->description}}</textarea>
    </div>
</div>


</div>


<div class="row">
 <div class="col-sm-12">
<br>
<div class="table-responsive">
        <table class="table table-bordered table-striped" id="dynamicTable">  
            <tr>
                <th>اسم الحساب </th>
                <th>الوصف</th>
                <th>دائن </th>
				<th>مدين </th>
                <th>الرصيد </th>
            </tr>
            @foreach($entry->actions as $acction)
                <tr>  
                    <td><input type="text" class="form-control" value="{{$acction->tree->name}}" disabled/></td>  
                    <td><input type="text" class="form-control" value="{{$acction->description}}" disabled/></td>  
                    <td><input type="number" step="0.001" value="{{$acction->credit}}" class="form-control"disabled/></td>  
    				<td><input type="number" step="0.001" value="{{$acction->debit}}" class="form-control" disabled/></td> 
                    <td><input type="number" step="0.001" value="{{$acction->balance}}" class="form-control" disabled/></td>  
                </tr>
            @endforeach
        </table> 
		</div>
        
</div>
</div>

        <div class="row">
            <div class="col-lg-5">
     --
          </div> 

 <div class="col-lg-3">
    <div class="well well-sm" style="background-color: #8dc1ff !important;">
<span>دائن</span><input type="text" value="{{$entry->actions->sum('credit')}}" style="background: transparent; border: none;text-align:center;" disabled/>
 </div>
</div>

 <div class="col-lg-3">
    <div class="well well-sm" style="background-color: #ffc6b9 !important;">
<span>مدين</span><input type="text" value="{{$entry->actions->sum('debit')}}" style="background: transparent; border: none;text-align:center;" disabled/>
</div>
 </div>


 <div class="col-lg-1">
 </div>

</div>


</div>
</div>

            </div>
        </div>


<script type="text/javascript">
  function openmodle(){
    document.getElementById("iframe").src="{{url('printdailyentry')}}/{{ $entry->id }}";
  }
</script>
    @endsection

    