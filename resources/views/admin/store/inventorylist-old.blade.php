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
        <table class="table table-bordered" id="example">
            <thead>
              <tr>
                <th>#</th>
                <th>الباركود </th>
                <th>اسم الصنف ar</th>
                <th>اسم الصنف en</th>
                <th>الكمية</th>
                <th>كمية فعلية</th>
                <th>مدين</th>
                <th>دائن</th>
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
                <td><input name="current_qty" data-product_id="{{$product->id}}" type="number" class="form-input current_qty" /></td>
                <td class="debit" id="debit_{{$product->id}}"></td>
                <td class="creditor" id="creditor_{{$product->id}}"></td>

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



$(document).ready(function() {
    $('#example').DataTable({

        buttons: [
            {
                extend:'copy',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible',
                    text:'الطباعة'
                }
            },{
                extend:'print',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible',
                    text:'الطباعة'
                }
            },{
                extend:'excel',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible',
                    text:'excel'
                }
            }
        ],

        initComplete: function () {
            this.api().columns([1,2,3,4]).every(function () {
                var column = this;
                var search = $(`<input style="font-size: 85%;height: 15px;width: 100%" class="form-control form-control-sm" type="text" placeholder="بحث .... ">`)
                    .appendTo($(column.footer()).empty())
                    .on('change input', function () {
                        var val = $(this).val()

                        column
                            .search(val ? val : '', true, false)
                            .draw();
                    });
            });
        },

        dom: 'Bfrtip',
        order: false,
        searching: true
    });
} );
</script>

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


        //get product by name or code
        /*$('.product_id').keyup(function(){
            var value = $('.product_id').val();

            $.ajax({
                url: "{{url('ajax_search_name')}}/"+ value,
                dataType: 'json',
                type: 'GET',
                cache: false,
                async: true,
                success: function (data) {
                    if(!data.error){
                        console.log("success");
                        //check_data(data.pro);
                    }
                    else{
                        if(data.status == 1){
                            alert(data.message);
                            $('.product_id').val('');
                            //document.getElementById("barcodeScannerVal").value = '';
                        }
                    }
                    //$('#DivId').hide()
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    //console.log(errorThrown);
                    //alert(errorThrown);
                }
            })

        })*/

    </script>

    @endsection


