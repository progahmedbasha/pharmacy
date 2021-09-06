@extends('admin.layouts.header')

@section('content')



<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
     
<div class="analytics-sparkle-area">
  <div class="container-fluid">
  <br> 
  <!--<button type="button" class="btn btn-success" onclick="openmodle()"><i class="fa fa-print" aria-hidden="true"></i> طباعة الفاتورة الإرجاع</button>-->
<a href="{{url()->previous()}}" type="button" class="btn btn-info">رجوع</a>
@if($return_bill->isClosed == 0)
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
        <form action="{{route('return_bil_pay_part')}}" method="post">
          @csrf

        <input type="hidden" name="return_id" value="{{$return_bill->id}}" required>
        <input type="hidden" name="supp_id" value="{{$return_bill->bill->supplier_id}}" required>
        
        <div class="form-group">
          <label for="email">المبلغ</label><br>
          <input type="number" step="0.001" min="1" max="{{$return_bill->total_amount - round($return_bill->return_payments()->sum('paid_amount'),2)}}" class="form-control" name="amount_val" required>
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
    <div class="panel-heading">تفاصيل الفاتورة الإرجاع رقم : {{$return_bill->return_number}}</div>
    <div class="panel-body">

  <div class="row">

    <div class="col-md-3">
        <div class="form-group">
          <label for="email">أنشيء بواسطة</label><br>
          <input type="text" class="form-control" value="{{$return_bill->user->name}}" disabled>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
          <label for="email">المورد</label><br>
          <input type="text" class="form-control" value="{{$return_bill->bill->supplier->name}}" disabled>
        </select>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
          <label for="pwd">رقم حساب المورد</label>
          <input type="text" class="form-control" value="{{$return_bill->bill->supplier->tree->id_code}}" disabled>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
          <label for="pwd">تاريخ الفاتورة الإرجاع</label>
          <input type="date" class="form-control" name="bill_date" value="{{$return_bill->return_date}}" disabled>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
          <label for="email">إجمالي الاصناف</label>
          <input type="number" class="form-control" value="{{count($return_bill->return_products)}}" readonly>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
          <label for="pwd">الإجمالي قبل الضريبة</label>
          <input type="number" step="0.001" class="form-control" value="{{$return_bill->total_before_tax}}" readonly>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
          <label for="pwd">إجمالي الضريبة</label>
          <input type="number" step="0.001" class="form-control" value="{{$return_bill->total_tax}}" readonly>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
          <label for="email"> الإجمالي النهائي</label>
          <input type="number" step="0.001" class="form-control" value="{{$return_bill->total_amount}}" readonly>
        </div>
    </div>


    <div class="col-md-3">
        <div class="form-group">
          <label for="pwd">طريقة الدفع</label>
          @if($return_bill->payment_status == 0)
            <input type="text" class="form-control" value="الدفع كاملاً" readonly>
          @elseif($return_bill->payment_status == 1)
            <input type="text" class="form-control" value="الدفع لاحقاً" readonly>
          @else
            <input type="text" class="form-control" value="دفع جزء" readonly>
          @endif
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
          <label for="pwd">حالة الدفع</label>
          @if($return_bill->isClosed == 1)
            <input type="text" class="form-control" value="مغلق" readonly>
          @else
            <input type="text" class="form-control" value="غير مغلق" readonly>
          @endif
        </div>
    </div>

  </div>


<div class="row">
 <div class="col-sm-12">
  <div class="well">بيانات المنتجات</div>
<div class="table-responsive">
    <table class="table table-bordered table-striped main" id="dynamicTable">  
      <tr>
        <th style="width:300px;">اســـم المنتـــج</th>
        <th style="width:120px;">تاريخ الإنتاج</th>
        <th style="width:120px;">تاريخ الإنتهاء</th>
        <th>السعر</th>
        <!--<th>الوحدة</th>-->
        <th>الكمية</th>
        <th>قيمة الضريبة</th>
        <th>الاجمالي</th>
      </tr>
      @foreach($return_bill->return_products as $item)
        <tr>  
          <td>{{$item->bill_products->product_date->product->item->name}}</td> 
          <td>{{$item->bill_products->product_date->production_date}}</td> 
          <td>{{$item->bill_products->product_date->expire_date}}</td> 
          <td>{{$item->bill_products->product_date->cost}}</td> 
          <td>{{$item->quantity}}</td>   
          <td>{{$item->tax}}</td> 
          <td>{{$item->amount}}</td> 
          
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
          @foreach($return_bill->return_payments as $index=>$value)
            <tr> 
              <td>{{$index+1}}</td>
              <td>{{$value->user->name}}</td>
              <td>{{$value->paid_amount}}</td>
              <td>{{$value->remaining_amount}}</td>
              <td>@if($value->pay_way == 0) كاش @else شبكة @endif</td>
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
    document.getElementById("iframe").src="{{url('printpurchasebill')}}/{{ $return_bill->id }}";
  }
</script>
    @endsection

    