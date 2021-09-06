@extends('admin.layouts.header')

@section('content')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>


<style>
#com_info{
display:none;
}
  </style>
          <div class="breadcome-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="breadcome-list">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <ul class="breadcome-menu">
                                            <!--<li><a href="#">Home</a> <span class="bread-slash">/</span>
                                            </li>-->
                                            <li><span class="bread-blod">اضافة قيد</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
     
        <div class="analytics-sparkle-area">
            <div class="container-fluid">

			

<div class="panel panel-default">
  <div class="panel-body">
<form action="{{route('add_new_entry')}}"  method="post">
@csrf
<div class="row">

<div class="col-md-12">
    <div class="form-group">
      <label for="email">التاريخ</label>
      <input type="date" class="form-control" name="ent_date" value="{{date('Y-m-d')}}">
    </div>
</div>

<div class="col-md-12">
    <div class="form-group">
      <label for="pwd">الوصف</label>
      <textarea rows="4" class="form-control" name="ent_description" ></textarea>
    </div>
</div>


</div>


<div class="row">
 <div class="col-sm-12">
<br><button type="button" name="add" id="add" class="btn btn-success"><i class="fa fa-plus"></i></button><br><br>
<div class="table-responsive">
        <table class="table table-bordered table-striped" id="dynamicTable">  
            <tr>
                <th>اسم الحساب *</th>
                <th>الوصف</th>
                <th>دائن *</th>
				<th>مدين *	</th>
				<th>حذف</th>
            </tr>
            <tr>  
                <td>
                    <select name="accounts[]" class="form-control select2" data-live-search="true">
                    <option selected disabled>إختر الحساب</option>
                    @foreach($tree_accounts as $value)
                        <option value="{{$value->id}}">{{$value->name}} {{$value->id_code}}</option>
                    @endforeach
                    </select>
                </td>  
                <td><input type="text" name="description[]"  class="form-control" /></td>  
                <td><input type="number" step="0.001" value="0" name="credit[]" id="credit0" class="form-control" onChange="cleardebit(0)" onkeyup="this.onchange();" onkeydown="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();"/></td>  
				<td><input type="number" step="0.001" value="0" name="debit[]" id="debit0" class="form-control" onChange="clearcredit(0)" onkeyup="this.onchange();" onkeydown="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();"/></td>  
                <td><button type="button" class="btn btn-danger remove-tr"><i class="fa fa-trash"></i></button></td>  
            </tr>  
        </table> 
		</div>
        


</div>
</div>

        <div class="row">
            <div class="col-lg-5">
     --
          </div> 

 <div class="col-lg-3">
    <div class="well well-sm" style="background-color: #8dc1ff !important;">
<span>دائن</span><input type="text" value="00" id="credit" name="tot_credit" style="background: transparent; border: none;text-align:center;" disabled/>
 </div>
</div>

 <div class="col-lg-3">
    <div class="well well-sm" style="background-color: #ffc6b9 !important;">
<span>مدين</span><input type="text" value="00" id="debit" name="tot_debit" style="background: transparent; border: none;text-align:center;" disabled/>
</div>
 </div>


 <div class="col-lg-1">
 </div>

</div>



<div class="row">
   <div class="col-md-12">
      <button type="submit" class="btn btn-primary">حفظ</button>
    </div>
</div>

  </form>
</div>
</div>

            </div>
        </div>

<script type="text/javascript">

    function selectRefresh() {
    $('.select2').select2({
      tags: true,
      placeholder: "Select an Option",
      allowClear: true,
      width: '100%'
    });
  }
   
    var i = 0;
       
    $("#add").click(function(){
   
        ++i;
   
        $("#dynamicTable").append('<tr><td><select name="accounts[]" class="form-control select2"><option selected disabled>إختر الحساب</option>@foreach($tree_accounts as $value)<option value="{{$value->id}}">{{$value->name}} {{$value->id_code}} </option> @endforeach</select></td> <td><input type="text" name="description[]" class="form-control" /></td> <td><input type="number" step="0.001" value="0" name="credit[]" id="credit'+i+'" class="form-control" onChange="cleardebit('+i+')" onkeyup="this.onchange();" onkeydown="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();"/></td> <td><input type="number" step="0.001" value="0" name="debit[]" id="debit'+i+'" class="form-control" onChange="clearcredit('+i+')"onkeyup="this.onchange();" onkeydown="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();"/></td>   <td><button type="button" class="btn btn-danger remove-tr"><i class="fa fa-trash"></i></button></td></tr>');
        selectRefresh();
    });
   
    $(document).on('click', '.remove-tr', function(){  
         $(this).parents('tr').remove();
    }); 

    $(document).ready(function() {
        selectRefresh();
    });

</script>

<script type="text/javascript">

    function cleardebit(k){
        document.getElementById("debit"+k).value = 0;
        calc_credit();
        calc_debit();
    }

    function clearcredit(k){
        document.getElementById("credit"+k).value = 0;
        calc_debit();
        calc_credit();
    }

    function calc_debit(){
        var x = document.getElementsByName("debit[]");
        var tot = 0;
        for(var i = 0 ; i < x.length ; i++){
          tot += parseFloat(x[i].value);
        }
        document.getElementById("debit").value = tot;
    }

    function calc_credit(){
        var x = document.getElementsByName("credit[]");
        var tot = 0;
        for(var i = 0 ; i < x.length ; i++){
          tot += parseFloat(x[i].value);
        }
        document.getElementById("credit").value = tot;
    }
   
</script>
    @endsection

    