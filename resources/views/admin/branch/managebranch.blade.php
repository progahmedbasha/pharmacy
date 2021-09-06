@extends('admin.layouts.header')

@section('content')
    
        <div class="analytics-sparkle-area">
            <div class="container-fluid">
			
      <br>
			<a href="{{url('addbranch')}}"  class="btn btn-success">{{ __('branch.add_branch') }}</a>
			<br>

<br>
<div class="panel panel-default">
  
  <div class="panel-body">
<div class="table-responsive">
<table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>{{ __('branch.branch_name') }}</th>
    		<th>{{ __('branch.employee') }}</th>
    		<th>{{ __('branch.country') }}</th>
    		<th>{{ __('branch.city') }}</th>
    		<th>{{ __('branch.address') }}</th>
    		<th>{{ __('branch.settings') }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach($branches as $index=>$value)
      <tr>
        <td>{{$index+1}}</td>
        <td>{{$value->name}}</td>
		    <td>{{$value->employee->name}}</td>
		    <td>{{$value->country->country}}</td>
		    <td>{{$value->city}}</td>
		    <td>{{$value->address}}</td>
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

    