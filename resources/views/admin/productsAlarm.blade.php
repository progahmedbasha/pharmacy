<link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet">

<div class="container">
    <div class="table-responsive">
        <h3 style="text-align: center">المنتجات التى ستنتهى صلاحيتها قريياً</h3>

        <table class="table table-bordered" id="myTable">
            <thead>
            <tr>
                <th>#</th>
                <th>اسم الصنف ar</th>
                <th>اسم الصنف en</th>
                <th>تاريخ الإنتهاء</th>
                <!--<th>التكلفة</th>-->
            </tr>
            </thead>
            <tbody id="myTable">
            @foreach($getProductsWithDate as $index=>$productDate)
                <tr>
                    <td>{{$index+1}}</td>
                    <td>{{$productDate->product->item->name_en??''}}</td>
                    <td>{{$productDate->product->item->name_ar??''}}</td>
                    <td>{{$productDate->expire_date}}</td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="table-responsive" style="margin-top: 30px;margin-bottom: 20px">
        <h3 style="text-align: center">المنتجات التى ستنتهى كميتها </h3>

        <table class="table table-bordered" id="myTable2">
            <thead>
            <tr>
                <th>#</th>
                <th>اسم الصنف ar</th>
                <th>اسم الصنف en</th>
                <th>الكمية</th>
                <!--<th>التكلفة</th>-->
            </tr>
            </thead>
            <tbody id="myTable">
            @foreach($getProductsWithQTY as $index=>$productQTY)

                <tr>
                    <td>{{$index+1}}</td>
                    <td>{{$productQTY->product->item->name_en??''}}</td>
                    <td>{{$productQTY->product->item->name_ar??''}}</td>
                    <td>{{$productQTY->quantity}}</td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>



<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
<script>
    $('#myTable').DataTable( {
        buttons: [
            'copy', 'excel', 'pdf'
        ]
    } );
    $('#myTable2').DataTable( {
        buttons: [
            'copy', 'excel', 'pdf'
        ],order: [
            [3, "desc"]
        ],
    } );
</script>
