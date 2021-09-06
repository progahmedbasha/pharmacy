@extends('admin.layouts.header')

@section('content')


    <div class="analytics-sparkle-area">
        <div class="container-fluid">
            {{--<br>
            ادارة الجرد:<a href="#" class="btn btn-success">تحميل ملف</a>
            <br><br>
                --}}

            <br>
            <div class="panel panel-default">
                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-6">
                            <form method="get" class="form-inline has-validation-callback" action="{{route('inventorylist')}}">

                                <select class="form-control input-lg" name="store_id">
                                    <option value="0">كل المخازن</option>
                                    @foreach($stores as $store)
                                        <option value="{{$store->id}}" {{ Request::get('store_id') == $store->id ? 'selected': ''}}>{{$store->store_name_ar}}</option>
                                    @endforeach
                                </select>

                                <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i></button>
                                <a href="{{route('inventorylist')}}" class="btn btn-danger" style="margin-top:0px;"><i class="fa fa-times"></i></a>
                            </form>
                        </div>


                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" >
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>الباركود </th>
                                <th>اسم الصنف ar</th>
                                <th>اسم الصنف en</th>
                                <th>الكمية</th>
                                <th>الإجراءات</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $index=>$product)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$product->product->barcode}}</td>
                                    <td>{{$product->name_ar}}</td>
                                    <td>{{$product->name_en}}</td>
                                    <td class="system_qty">
                                        @if(isset($product->product))
                                            {{$product->product->total_quantity}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td><a href="{{route('product_inventory', $product->id)}}" class="btn btn-info">رصيد المنتج</a></td>

                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


   

    <script>
        //add current qty of the product
        $('body').on('change', '.current_qty', function(){
            $(this).prop( "disabled", true );

            var product_id = $(this).data('product_id');
            var current_qty = $(this).val();
            var system_qty = $(this).closest('tr').find('.system_qty').text();
            postData = {
                product_id : product_id,
                current_qty: current_qty,
                system_qty : system_qty,
                "_token": "{{ csrf_token() }}"
            }

            $.post('{{route("check_product_qty")}}', postData, function(result){

                $('#debit_'+product_id).text(result['debit']);
                $('#creditor_'+product_id).text(result['creditor']);

            });
        });


    </script>

@endsection


