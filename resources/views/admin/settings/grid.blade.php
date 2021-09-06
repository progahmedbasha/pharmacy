@extends('admin.layouts.header')

@section('content')



<br>
<div class="panel panel-default">
  <div class="panel-body">
<div class="table-responsive">
<table class="table table-bordered">
    <thead>
      <tr>
        <th>اسم الموقع</th>
		<th>اسم الموقع EN</th>

		<th>الاجراءات</th>
      </tr>
    </thead>
    <tbody>
        @foreach($setting as $row)
            <tr>
                <td>{{$row->site_name}}</td>
                <td>{{$row->site_name_en}}</td>
                <td>
                    <a href="{{route('MainSettings.edit', $row->id)}}" class="btn btn-info">
                        <i class="fa fa-edit" aria-hidden="true"></i>
                    </a>
                </td>
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

