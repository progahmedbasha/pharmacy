@extends('admin.layouts.header')

@section('content')



<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
     
<div class="analytics-sparkle-area">
  <div class="container-fluid">

  <br> <br> <br>
<button type="button" class="btn btn-success" onclick="openmodle()"><i class="fa fa-print" aria-hidden="true"></i> طباعة الفاتورة</button>
<a href="{{url()->previous()}}" type="button" class="btn btn-info">رجوع</a>

@if($bill->is_paid == 0)
<!-- Trigger the modal with a button -->
<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">دفع المستحقات</button>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">المبلغ المالي المستحق</h4>
      </div>
      <div class="modal-body">
        <form action="{{route('bil_pay_part')}}" method="post">
          @csrf
          <input type="hidden" name="bill_id" value="{{$bill->id}}" required>
          <input type="hidden" name="cus_id" value="{{$bill->customer_id}}" required>
        
        <div class="form-group">
          <label for="email">المبلغ</label><br>
          <input type="number" step="0.001" class="form-control" name="amount_val" min="1" max="{{$bill->remaining_amount}}" required>
        </div>
        <div class="form-group">
          <label for="sel1">طريقة الدفع</label>
          <select class="form-control" name="payment_type">
            <option value="0">كاش</option>
            <option value="1">شبكة</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">حفظ</button>
      </form>
      </div>

    </div>
  </div>
</div>
    @endif

<iframe id="iframe" src="" style="display:none;"></iframe>
<br><br>
  <div class="panel panel-default">
    <div class="panel-heading">تفاصيل الفاتورة</div>
    <div class="panel-body">

  <div class="row">

    <div class="col-md-3">
        <div class="form-group">
          <label for="email">أنشيء بواسطة</label><br>
          <input type="text" class="form-control" value="{{$bill->user->name}}" disabled>
        </select>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
          <label for="email">العميل</label><br>
          <input type="text" class="form-control" value="{{$bill->customer->name}}" disabled>
        </select>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
          <label for="pwd">رقم حساب العميل</label>
          <input type="text" class="form-control" value="{{$bill->customer->tree->id_code}}" disabled>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
          <label for="pwd">رصيد العميل</label>
          <input type="text" class="form-control" value="{{$bill->customer->tree->balance}}" disabled>
        </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label for="email">نوع الفاتورة</label>
        @if($bill->customer->type == 0)
          <input type="text"  class="form-control" value="نقدي" disabled>
        @else
          <input type="text"  class="form-control" value="آجل" disabled>
          @endif
      </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
          <label for="pwd">تاريخ الفاتورة</label>
          <input type="date" class="form-control" name="bill_date" value="{{$bill->bill_date}}" disabled>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
          <label for="pwd">مندوب المبيعات</label>
          @if($bill->employee != null)
            <input type="text" class="form-control" value="{{$bill->employee->name}}" disabled>
          @else
            <input type="text" class="form-control" disabled>
          @endif
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
          <label for="email">إجمالي الاصناف</label>
          <input type="number" class="form-control" value="{{count($bill->bill_items)}}" readonly>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
          <label for="pwd">إجمالي الخصم</label>
          <input type="number" class="form-control" value="{{$bill->total_discount}}" readonly>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
          <label for="pwd">الإجمالي قبل الضريبة</label>
          <input type="number" step="0.001" class="form-control" value="{{$bill->total_before_tax}}" readonly>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
          <label for="pwd">إجمالي الضريبة</label>
          <input type="number" step="0.001" class="form-control" value="{{$bill->total_tax}}" readonly>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
          <label for="email"> الإجمالي النهائي</label>
          <input type="number" step="0.001" class="form-control" value="{{$bill->total_final}}" readonly>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
          <label for="pwd">تاريخ الاستحقاق</label>
          <input type="date" class="form-control" value="{{$bill->due_date}}" readonly>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
          <label for="pwd">حالة الدفع</label>
          @if($bill->is_paid == 1)
            <input type="text" class="form-control" value="مكتمل الدفع" readonly>
          @else
            <input type="text" class="form-control" value="غير مكتمل الدفع" readonly>
          @endif
        </div>
    </div>

  </div>


<div class="row">
 <div class="col-sm-12">
<br><br>
<div class="table-responsive">
        <table class="table table-bordered table-striped main" id="dynamicTable">  
          <tr>
            <th style="width:300px;">اســـم المنتـــج</th>
            <th>السعر</th>
            <th>الكمية</th>
            <th>الخصم</th>
            <th>قيمة الضريبة</th>
            <th>الاجمالي</th>
          </tr>
          @foreach($bill->bill_items as $item)
            <tr>  
              <td><input type="text"  class="form-control" value="{{$item->item->name}}" readonly/></td> 
              <td><input type="number" step="0.001"  class="form-control" value="{{$item->price}}" readonly/></td> 
              <td><input type="number" class="form-control" value="{{$item->quantity}}" readonly/></td>  
              <td><input type="number" class="form-control" value="{{$item->product_discount}}" readonly/></td> 
              <td><input type="number" step="0.001" class="form-control" value="{{$item->tax_value}}"  readonly></td> 
              <td><input type="number" class="form-control" value="{{$item->total_price}}" readonly/></td> 
              
            </tr> 
          @endforeach 
        </table> 
    </div>

     <div class="well">بيانات الدفعات المستحقة</div>
<div class="table-responsive">
    <table class="table table-bordered table-striped main" id="dynamicTable">  
      <tr>
        <th>#</th>
        <th>المستخدم</th>
        <th>المبلغ</th>
        <th>المتبقي</th>
        <th>طريقة الدفع</th>
        <th>التاريخ</th>
      </tr>
      @foreach($bill->bill_payments as $index=>$value)
        <tr> 
          <td>{{$index+1}}</td>
          <td>{{$value->user->name}}</td>
          <td>{{$value->cash + $value->visa}}</td>
          <td>{{$value->remaining_amount}}</td>
          @if($value->pay_way == 0)
          <td>كاش</td>
          @else
          <td>شبكة</td>
          @endif
          <td>{{$value->created_at}}</td>
        </tr>
      @endforeach


    </table>
</div>
</div>
</div>




  
</div>
</div>


</div>



</div>

<script type="text/javascript">
  function openmodle(){
    document.getElementById("iframe").src="{{url('printsalebill')}}/{{ $bill->id }}";
  }
</script>
    @endsection

    