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
<button type="button"  class="btn btn-primary btn-lg">
 <a href="{{url('inventory')}}">جرد المنتجات </a>
</button>
<button type="button" class="btn btn-secondary btn-lg">Large button</button>

<br>

</div>
</div>
            </div>
        </div>



    @endsection

    