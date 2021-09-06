<div class="table-responsive">
<table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>رقم الفاتورة</th>
        <th>تاريخ الفاتورة</th>
		<th>أنشئ بواسطة</th>
		<th>اجمالي المبلغ</th>
		<th>المدفوع</th>
		<th>المتبقي</th>
		<th>الحالة</th>
        @if(!isset($report_page) )
		<th>الاجراءات</th>
        @endif
      </tr>
    </thead>
    <tbody>
     @foreach($bills as $index=>$value)
      <tr>
        <td>{{$index+1}}</td>
        <td>{{$value->bill_number}}</td>
        <td>{{$value->bill_date}}</td>
		<td>{{$value->user->name}}</td>
		<td>{{$value->total_final}}</td>
        <td>{{round($value->paid_amount,2)}}</td>
        <td>{{$value->remaining_amount}}</td>
        @if($value->is_paid == 1)
			<td>مكتمل</td>
		@else
			<td>غير مكتمل</td>
		@endif
        
        @if(!isset($report_page) )
            <td> <a href="{{url('salebilldetail')}}/{{$value->id}}" class="btn btn-info">
                <i class="fa fa-eye" aria-hidden="true"></i></a>
    
                <button type="button" class="btn btn-success"  style="margin-top: 15px;" onclick='openmodle("{{url('printsalebill')}}/{{ $value->id }}")'>
                    <i class="fa fa-print" aria-hidden="true"></i></button>
    
                <a href="{{url('returnbillaction')}}/{{$value->id}}" class="btn btn-danger">
                <i class="fa fa-reply-all" aria-hidden="true"></i></a>
    
    
            </td>
        @endif

      </tr>
      @endforeach
    </tbody>
  </table>
</div>