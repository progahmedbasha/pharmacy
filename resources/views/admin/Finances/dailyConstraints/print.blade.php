@extends('layouts.print.index')
@section('content')
<!-- Address and Barcode -->
<table style="width: 95%; border-collapse: collapse; margin: auto;">
    <tbody>
    <tr>
        <td rowspan="4" style="width: 30%;  text-align: center; vertical-align: bottom;">
            <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($find->id, 'C39','2','30')}}" alt="barcode" />
        </td>
        <td style="width: 40%; text-align: center;" rowspan="4">
            <h2 style="margin: 2px; font-family: 'DroidKufi-Regular',serif; font-size: 1.1rem;">قيد يومي </h2>
        </td>
        <td colspan="2" style="height: 25px;"></td>
    </tr>

    <tr>
        <td colspan="2" style="height:25px"></td>
    </tr>
    </tbody>
</table>


<!-- Sender Table -->
<table style="width: 95%;
          border-collapse: collapse;
          margin-left: auto;
          margin-right: auto;
          margin-top: 20px;
          font-size: 14px;
          border: 1px solid;
    ">
    <tbody>
    <tr style="direction: rtl; font-family: 'hanimation',serif;">
        <td style="text-align: right;padding: 10px; max-width: 25%"><span style="">رقم القيد</span> : <span> {{ $find->id ?? '' }}</span>
        </td>
        <td style="text-align: right;padding: 10px; max-width: 25%"><span style="">التاريخ</span> : <span> {{ $find->date ?? '' }}</span>
        </td>
        <td style="text-align: right;padding: 10px; max-width: 25%"><span style="">الإجمالى</span> : <span> {{ $find->value ?? '' }} ر.س </span>
        </td>
        <td style="text-align: right;padding: 10px; max-width: 25%"><span style="">البيان</span> : <span> {{ $find->statement ?? '' }}</span>
        </td>


    </tr>

    </tbody>
</table>


<!-- Info Table -->
<fieldset style="padding: 5px; width: 95%; box-sizing: border-box; margin: 10px auto;">
    <legend
        style="text-align: center; font-size: 14px; padding: 1px 20px; background: #2f75b3; font-family: 'DroidKufi-Regular', serif; color: white; border-radius: 3px;">
        تفاصيل القيد اليومي
    </legend>

    @foreach($find->contain_details as $details)

        @if(!$loop->first)
            <center>ــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــ</center>
        @endif
    <table dir="rtl"
        style="width: 100%; border-collapse: collapse; margin-left: auto; margin-right: auto; margin-top: 10px; font-size: 14px;">
        <tbody>




        <tr>
            <td style="text-align: right;font-family: 'hanimation',serif;">الحساب</td>
            <td style="text-align: center;">{{ $details->account_rl->name }}</td>
            <td style="text-align: right;font-family: 'hanimation',serif;">طبيعة الحساب</td>
            <td style="text-align: center;">{{ $details->type == 'debit'?'مدين':'داين' }}</td>

        </tr>
            <tr>
                <td style="text-align: right;font-family: 'hanimation',serif;">القيمة </td>
                <td style="text-align: center;">{{ $details->type == 'debit'? $details->debit_value :$details->creditor_value}} ر.س </td>
                <td style="text-align: right;font-family: 'hanimation',serif;">بيان الحساب</td>
                <td style="text-align: center;">{{$details->statement}}</td>
            </tr>
        </tbody>
    </table>
    @endforeach

</fieldset>

<!-- Notes -->
<p
    style="font-size: 12px; font-weight:bold ; font-family: 'DroidKufi-Regular', serif; color: #f55459; direction: rtl; text-align: center;    box-sizing: border-box;
        padding: 5px;
        width: 95%;
        margin: auto;">
    ملاحظة : {{$printsetting ->note_ar}}
</p>

<!-- pledge -->
<table
    style="width: 95%; border-collapse: collapse; margin-left: auto; margin-right: auto; margin-top: 10px; font-size: 12px; font-weight:bold; font-family: 'DroidKufi-Regular', serif; direction: rtl;">
    <tbody>
    <tr>
        <td colspan="3" style="text-align: center; padding-bottom: 10px;">{{$printsetting ->note_en}}
        </td>
    </tr>

    <tr>
        <td style="text-align: center;padding-bottom:5px">توقيع المسئول</td>
    </tr>
    <tr>
        <td style="text-align: center;">................................</td>
    </tr>
    </tbody>
</table>

<!-- receiver signature -->
<table style="width: 95%; border-collapse: collapse; margin-left: auto; margin-right: auto; margin-top: 10px; font-size: 12px;">
    <tbody>

    <tr style="direction: rtl; font-family: 'hanimation',serif;">
        <td style="padding: 2px; width: 33.333%; text-align: center;">الختم<span></span></td>
        <td style="text-align: right; padding: 2px; width: 33.333%;"></td>

    </tr>

    </tbody>
</table>
@endsection
