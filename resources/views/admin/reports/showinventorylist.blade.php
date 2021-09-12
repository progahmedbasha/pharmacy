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
          <form method="POST" class="form-inline has-validation-callback" action="{{route('inventory.store')}}">
             @csrf
            <select class="form-control input-lg" name="store_id">
                <option value="0">كل المخازن</option>
                @foreach($stores as $store)
                <option value="{{$store->id}}" {{ Request::get('store_id') == $store->id ? 'selected': ''}}>{{$store->store_name_ar}}</option>
                 @endforeach
             </select>

              <!-- <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i></button> -->
              <button type="submit"  class="btn btn-primary btn-lg">اضافة ورقة جرد</button>
                <!-- <a href="{{route('inventorylist')}}" class="btn btn-danger" style="margin-top:0px;"><i class="fa fa-times"></i></a> -->
              </form>

<!-- <button type="button" href="#" class="btn btn-primary btn-lg">اضافة ورقة جرد</button> -->

<br>

<br>

<div class="table-responsive">
<table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>إسم المخزن</th>
        <th>حالة الجرد</th>
        <th>تاريخ البدء</th>
        <th>تاريخ الانتهاء</th>
		
		
      </tr>
    </thead>
    <tbody>
     @foreach($inventory as $index=>$item)
      <tr>
        <td>{{$index+1}}</td>
        <td>{{$item->store->store_name}}</td>

        @if($item->status == 0 )
        <td>جاري التحديث</td>
        @else
        <td>جاري الانتهاء</td>
        @endif
        <td>{{$item->created_at}}</td>
        <td>{{$item->updated_at}}</td>
		
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

    