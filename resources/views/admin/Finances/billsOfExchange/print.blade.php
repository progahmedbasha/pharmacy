@extends('layouts.print.index')
@section('content')
    <style>
        .line{
            -webkit-text-decoration-line: underline; /* Safari */
            text-decoration-line: underline;
        }
    </style>
<!-- Address and Barcode -->
<table style="width: 95%; border-collapse: collapse; margin: auto;">
    <tbody>
    <tr>
        <td rowspan="4" style="width: 30%;  text-align: center; vertical-align: bottom;">
{{--            <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($find->id, 'C39','2','30')}}" alt="barcode" />--}}
        </td>
        <td style="width: 40%; text-align: center;" rowspan="4">
            <h2 style="margin: 2px; font-family: 'DroidKufi-Regular',serif; font-size: 1.1rem;">سند صرف</h2>
        </td>
        <td colspan="2" style="height: 25px;"></td>
    </tr>
    <tr>
        <td
            style="text-align: center; font-size:13px; background-color:#2f75b3; color:white;font-family: 'DroidKufi-Regular',serif; ">
            التاريخ
        </td>
        <td
            style="text-align: center; font-size:13px; background-color:#2f75b3; color:white;font-family: 'DroidKufi-Regular',serif; ">
            No
        </td>
    </tr>
    <tr>
        <td style="text-align: center;font-size:13px"> {{ date(' H:i:s') }}</td>
        <td style="text-align: center;font-size:13px">{{ $find->id ?? '' }}</td>
    </tr>
    <tr>
        <td colspan="2" style="height:25px"></td>
    </tr>
    </tbody>


</table>
<fieldset style="font-weight: bolder">
    <div class="row" dir="rtl" style="margin: 10px">
        <div class="col-sm-4"  style="display: inline-block">سند صرف إلى : </div>
        <div class="col-sm-8" style="display: inline-block">{{$find->debit_rl ? $find->debit_rl->name:''}}</div>
    </div>

    <div class="row" dir="rtl" style="margin: 10px">
        <div class="col-sm-4"  style="display: inline-block">مبلغ وقدرة: </div>
        <div class="col-sm-8" style="display: inline-block">{{$find->value}} ر.س </div>
    </div>

    <div class="row" dir="rtl" style="margin: 10px">
        <div class="col-sm-4"  style="display: inline-block">وذلك عن: </div>
        <div class="col-sm-8" style="display: inline-block">{{$find->statement}}  </div>
    </div>

    <div class="row" dir="rtl" style="margin: 10px">
        <div class="col-sm-4"  style="display: inline-block"><h3 style="display: inline-block" class="{{$find->payment_type == 'cash'?'line':''}}">نقداً</h3 > / <h3 class="{{$find->payment_type == 'check'?'line':''}}" style="display: inline-block">شيك</h3> </div>
        <div style="display: inline-block" class="col-sm-1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
        <div class="col-sm-3" style="display: inline-block">بنك: {{$find->payment_type == 'check'?$find->creditor_rl->name:'........................'}}</div>
        <div style="display: inline-block" class="col-sm-1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
        <div class="col-sm-3" style="display: inline-block">رقمة: {{$find->payment_type == 'check'?$find->check_number:'........................'}}</div>
        <div style="display: inline-block" class="col-sm-1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
        <div class="col-sm-3" style="display: inline-block">تاريخ: {{$find->payment_type == 'check'?$find->check_date:'........................'}}</div>
    </div>

    <div class="row" dir="rtl" style="margin: 50px">
        <div class="col-sm-5" style="display: inline-block">
            توقيع الإستلام : ................................................
        </div>
        <div style="display: inline-block" class="col-sm-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>

        <div class="col-sm-5" style="display: inline-block">
            توقيع المدير العام : ................................................
        </div>
    </div>

</fieldset>
<br>

    <center>
        {{$printsetting->note_ar}}
    </center>
<br>
    <center>
        {{$printsetting->note_en}}
    </center>
@endsection
