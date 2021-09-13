
<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                
                                                <th><b>رقم الفاتورة</b></th>
                                                <th><b>تاريخ الفاتورة</b></th>
                                                <th><b>أنشئ بواسطة</b></th>
                                                <th><b>إسم العميل</b></th>
                                                <th><b>اجمالي المبلغ</b></th>
                                                <th><b>المدفوع</b></th>
                                                <th><b>المتبقي</b></th>
                                                <th><b>الحالة</b></th>
                                                                                               
                                                
                                                
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                           @foreach($bills as $item)
                                              <tr>
                                            
                                            <td>{{$item->bill_number}}</td>
                                            <td>{{$item->bill_date}}</td>
                                            <td>{{$item->user->name}}</td>
                                            <td>{{$item->customer->name}}</td>
                                            <td>{{$item->total_final}}</td>
                                            <td>{{round($item->paid_amount,2)}}</td>
                                            <td>{{$item->remaining_amount}}</td>
                                            @if($item->is_paid == 1)
                                                <td>مكتمل</td>
                                            @elseif(0)
                                                <td>غير مكتمل</td>
                                              @elseif(2)
                                                <td>مرتجع</td>
                                            @endif

                                           
                                              
                                              </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                              
                                                <th><b>Total</b></th>
                                               
                                                
                                                
                                            </tr>
                                        </tfoot>
                                         <tfoot>
                                            <tr>
                                                <th></th>
                                               
                                               
                                            </tr>
                                        </tfoot>
                                    </table>

