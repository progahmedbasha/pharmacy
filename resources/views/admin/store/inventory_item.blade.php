@extends('admin.layouts.header')

@section('content')




    <div class="analytics-sparkle-area">
        <div class="container-fluid">
            <br>
            <div class="panel panel-default">
                <div class="panel-heading">تقرير الجرد ل {{$product_data->name}}</div>
                <div class="panel-body">


                    <form action="{{route('check_product_qty')}}" method="post">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$product_data->id}}" />
                        <div class="row">


                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="email">الكمية الموجودة فى النظام</label>
                                    <input type="text" class="form-control" value="{{$product_data->product->total_quantity}}"  name="system_qty" readonly>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="email">الكمية الفعلية</label>
                                    <input type="text" class="form-control"  name="current_qty" required>
                                </div>
                            </div>



                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary">تحديث الكمية</button>
                                <a style="margin-top: 0px;" class="btn btn-info" href="{{route('inventorylist')}}"> رجوع</a>
                            </div>



                        </div><!-------row----->

                    </form>

                </div>
            </div>

        </div>
    </div>
    <br><br>
    </div>

    <script>

        function mainstore_enable(){
            document.getElementById("main_store1").style.display = "block";
        }

        function mainstore_disable(){
            document.getElementById("main_store1").style.display = "none";
        }

    </script>


@endsection
