@extends('admin.layouts.header')

@section('content')
<head>
<link rel="stylesheet" href="{{asset('treesection/dist/themes/default/style.min.css')}}" />
</head>
<style>

/*.menu .accordion-heading {  position: relative; }
.menu .accordion-heading .edit {
    position: absolute;
    top: 8px;
    right: 30px;
}
.menu .area { border-left: 4px solid #f38787; }
.menu .equipamento { border-left: 4px solid #65c465; }
.menu .ponto { border-left: 4px solid #98b3fa; }
.menu .collapse.in { overflow: visible; }

.treeRoot{
    border-left: 2px solid gray;
}

.treeRoot li {
    list-style: none;
    margin: 5px 20px 5px 0px; /*margin: 5px 0 5px 20px;*/
}
.treeRoot li[level='0'] {
    margin-left: 0;
}
.treeRoot li:not(.parentNode) {
    padding-left: 15px;
}
.triangle {
     width: 0;
  height: 0;
  border-top: 10px solid transparent;
  border-bottom: 10px solid transparent;

  border-right:10px solid blue;
    /*width:0;
    height:0;
    overflow:hidden;
    font-size: 0;
    line-height: 0;
    border-width:5px;
    transition: transform .2s;
    transform-origin: left center;
    border-style:solid dashed dashed dashed;
    border-color:transparent transparent transparent #000;*/
}
.closed .triangle {
    transform: rotateZ(90deg);
}
.treeRoot div.title {
    height: 21px;
    position: relative;
}
.treeRoot div.title i {
    position: absolute;
    top: 6px;
    right:0px; /*left: 0;*/
}
.treeRoot div.title p {
    position: absolute;
    top: 0;
    right:15px; /*left: 15px;*/
    margin: 0;
    font-size:18px;
}*/
</style>




     <div class="container" >

	<br>{{ __('accounttree.account_tree') }}: <hr>


        <div class="row" >



            <div class="col-md-8">

            <a class="btn btn-success" onclick="printTree()">{{'طباعة'}}</a>
            <!-- Button to Open the Modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
              {{ __('accounttree.add_account') }}
            </button>

<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header" style="background-color:#286090;color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="text-align:center;">{{ __('accounttree.add_account') }}</h4>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="{{route('add_new_accounttree')}}" method="post">
        @csrf
  <div class="form-group">
    <label for="email">{{ __('accounttree.name_arabic') }}</label>
    <input type="text" class="form-control" name="name_ar" required>
  </div>

   <div class="form-group">
    <label for="email">{{ __('accounttree.name_english') }}</label>
    <input type="text" class="form-control" name="name_en" required>
  </div>

  <div class="form-group">
    <label for="pwd">{{ __('accounttree.account_type') }}</label><br>
    <input type="radio"  name="acc_type" value="0"  checked>&nbsp;&nbsp;&nbsp;رئيسي&nbsp;&nbsp;
  <input type="radio"  name="acc_type" value="1" >&nbsp;&nbsp;&nbsp;فرعي
  </div>

  <div class="form-group">
    <label for="pwd">{{ __('accounttree.main_account') }}</label>
    <select class="form-control" name="acc_parent">
        @foreach($allaccountslist as $value)
        <option value="{{$value->id}}">{{$value->name_ar}}</option>
        @endforeach
    </select>
  </div>

  <div class="form-group">
    <label for="pwd">دائن / مدين</label><br>
    <input type="radio"  name="credit_debit" value="0"  checked>&nbsp;&nbsp;&nbsp;دائن&nbsp;&nbsp;
  <input type="radio"  name="credit_debit" value="1" >&nbsp;&nbsp;&nbsp;مدين

  </div>

    <div class="form-group">
    <label for="pwd">{{ __('accounttree.final_account') }}</label>
    <select class="form-control" name="final_acc">
        @foreach($final_accounts as $value)
       <option value="{{$value->id}}">{{$value->final_account}}</option>
       @endforeach
    </select>
  </div>

  <button type="submit" class="btn btn-primary">{{ __('accounttree.add_account') }}</button>
</form>
      </div>


    </div>
  </div>
</div>

</div><!--col9  -->

            <div class="col-md-4">
<div id="data" class="demo"></div>
<ul class="treeRoot"></ul>

<!--<h1>AJAX demo</h1>
	<div id="ajax" class="demo"></div>
-->
<?php /*
                @foreach($allaccounts as $index=>$value)

    <div class="row">
        <div class="span12">
            <div class="menu">
                <div class="accordion">
                    <!-- Áreas -->
                    <div class="accordion-group">
                        <!-- Área -->
                        <div class="accordion-heading area">
                            <a class="accordion-toggle" data-toggle="collapse" href=
                            "#area{{$index+1}}">{{$value->name_ar}} <br>#{{$index+1}}</a>
                        </div><!-- /Área -->

                        <div class="accordion-body collapse" id="area{{$index+1}}">
                            <div class="accordion-inner">
                                <div class="accordion" id="equipamento1">
                                    <!-- Equipamentos -->

                                    <div class="accordion-group">
                                        <div class="accordion-heading equipamento">
                                            <a class="accordion-toggle" data-parent=
                                            "#equipamento1-1" data-toggle="collapse" href=
                                            "#ponto{{$index+1}}-{{$index+1}}">Equipamento #{{$index+1}}-{{$index+1}}</a>

                                        </div><!-- Pontos -->

                                        <div class="accordion-body collapse" id="ponto{{$index+1}}-{{$index+1}}">
                                            <div class="accordion-inner">
                                                <div class="accordion" id="servico1">
                                                    <div class="accordion-group">
                                                        <div class=
                                                        "accordion-heading ponto">
                                                            <a class="accordion-toggle"
                                                            data-parent="#servico1-1-1"
                                                            data-toggle="collapse" href=
                                                            "#servico1-1-1">Ponto
                                                            #1-1-1</a>
                                                        </div><!-- Serviços -->

                                                        <div class=
                                                        "accordion-body collapse" id=
                                                        "servico1-1-1">
                                                            <div class="accordion-inner">
                                                                <ul class="nav nav-list">
                                                                    <li>
                                                                        <a href=
                                                                        "#"><i class=
                                                                        "icon-chevron-right">
                                                                        </i> Serviço
                                                                        #1-1-1-1</a>
                                                                    </li>

                                                                    <li>
                                                                        <a href=
                                                                        "#"><i class=
                                                                        "icon-chevron-right">
                                                                        </i> Serviço
                                                                        #1-1-1-2</a>
                                                                    </li>

                                                                    <li>
                                                                        <a href=
                                                                        "#"><i class=
                                                                        "icon-chevron-right">
                                                                        </i> Serviço
                                                                        #1-1-1-3</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div><!-- /Serviços -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /Pontos -->
                                    </div><!-- /Equipamentos -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /accordion -->
            </div>
        </div>
    </div>

    @endforeach
    */
    ?>

            </div>

</div><!--row  -->



</div><!--container  -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="{{asset('treesection/dist/jstree.min.js')}}"></script>

	<script>
    $('#html').jstree();




	var quotaTree1 = <?php echo json_encode($core); ?>;

	var quotaTree2 = JSON.parse(quotaTree1);
	console.log(quotaTree2);

	$('#data').jstree(quotaTree2);

    $('#data').on('ready.jstree', function() {
        $("#data").jstree("open_all");
    });

    $(document).on('click', '.jstree-anchor', function(e){
        e.preventDefault();
        var anchor = $(this).html();
        var result = anchor.split('#');
        var code   = result[1];

        window.location = '{{url('edit_account')}}'+'/'+code;
    });



    function printTree(){

        var divContents = $("#data").html();
        var printWindow = window.open('', '', 'height=800,width=1600');
        printWindow.document.write('<html><head><title>شجرة الحسابات</title>');
        printWindow.document.write('</head><body >');
        printWindow.document.write(divContents);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }

	</script>
    @endsection

