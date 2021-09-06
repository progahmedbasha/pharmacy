@extends('layouts.admin')



@section('content')

    <style>

        .settings-category .content {
            height: 140px;
            -webkit-box-shadow: 0px 0px 6px #00000030;
            box-shadow: 0px 0px 6px #00000030;
            border-radius: 6px;
            -webkit-transition: all .3s ease-in-out;
            transition: all .3s ease-in-out;
            background-color: white;
        }

        .settings-category .content h3 {
            font-weight: 600;
        }

        .settings-category .content i {
            font-size: 35px;
            color: #a6b7bf;
        }

        .settings-category .content:hover {
            -webkit-transform: scale(0.95);
            transform: scale(0.95);
            -webkit-box-shadow: 0px 0px 8px #186dde;
            box-shadow: 0px 0px 8px #186dde;
        }

        .settings-category .content h3 {
            font-weight: 600;
            color: black;
        }
    </style>

    <section class="settings-category my-5">

        <div class="row">

            {{---------------------------------}}
            <div class="col-lg-4 col-sm-6 mb-4">
                <a href="{{route('admin.accountsTree.index')}}">
                    <div class="content  d-flex align-items-center justify-content-center">
                        <div class="text-i">
                            <div class="w-100 mb-3 d-flex align-items-center justify-content-center">
                                <i class="fa fa-tree"></i>
                            </div>

                            <h3>
                               شجرة الحسابات
                            </h3>
                        </div>
                    </div>
                </a>

            </div>
            {{---------------------------------}}
            {{---------------------------------}}
            <div class="col-lg-4 col-sm-6 mb-4">
                <a href="{{route('admin.billsOfExchange.index')}}">
                    <div class="content  d-flex align-items-center justify-content-center">
                        <div class="text-i">
                            <div class="w-100 mb-3 d-flex align-items-center justify-content-center">
                                <i class="fa fa-money-bill-alt"></i>
                            </div>

                            <h3>
                                سندات الصرف
                            </h3>
                        </div>
                    </div>
                </a>

            </div>
            {{---------------------------------}}

            {{---------------------------------}}
            <div class="col-lg-4 col-sm-6 mb-4">
                <a href="{{route('admin.receipt.index')}}">
                    <div class="content  d-flex align-items-center justify-content-center">
                        <div class="text-i">
                            <div class="w-100 mb-3 d-flex align-items-center justify-content-center">
                                <i class="fa fa-dollar-sign"></i>
                            </div>

                            <h3>
                                سندات القبض
                            </h3>
                        </div>
                    </div>
                </a>

            </div>
            {{---------------------------------}}

{{--            -------------------------------}}
            <div class="col-lg-4 col-sm-6 mb-4">
                <a href="{{route('admin.dailyConstraints.index')}}">
                    <div class="content  d-flex align-items-center justify-content-center">
                        <div class="text-i">
                            <div class="w-100 mb-3 d-flex align-items-center justify-content-center">
                                <i class="fa fa-chart-area"></i>
                            </div>

                            <h3>
                                القيود اليومية
                            </h3>
                        </div>
                    </div>
                </a>
            </div>
        {{---------------------------------}}





        {{---------------------------------}}
            <div class="col-lg-4 col-sm-6 mb-4">
                <a href="{{route('admin.TrialBalance')}}">
                    <div class="content  d-flex align-items-center justify-content-center">
                        <div class="text-i">
                            <div class="w-100 mb-3 d-flex align-items-center justify-content-center">
                                <i class="fa fa-balance-scale"></i>
                            </div>

                            <h3>
                                ميزان المراجعة
                            </h3>
                        </div>
                    </div>
                </a>
            </div>
        {{---------------------------------}}


        {{---------------------------------}}
            <div class="col-lg-4 col-sm-6 mb-4">
                <a href="{{route('admin.incomeList.index')}}">
                    <div class="content  d-flex align-items-center justify-content-center">
                        <div class="text-i">
                            <div class="w-100 mb-3 d-flex align-items-center justify-content-center">
                                <i class="fa fa-dollar-sign"></i>
                            </div>

                            <h3>
                                قائمة الدخل
                            </h3>
                        </div>
                    </div>
                </a>
            </div>
        {{---------------------------------}}


{{--        --}}{{---------------------------------}}
{{--            <div class="col-lg-4 col-sm-6 mb-4">--}}
{{--                <a href="{{route('admin.statementOfFinancialPosition.index')}}">--}}
{{--                    <div class="content  d-flex align-items-center justify-content-center">--}}
{{--                        <div class="text-i">--}}
{{--                            <div class="w-100 mb-3 d-flex align-items-center justify-content-center">--}}
{{--                                <i class="fa fa-list-ol"></i>--}}
{{--                            </div>--}}

{{--                            <h3>--}}
{{--                                قائمة المركز المالى--}}
{{--                            </h3>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        --}}{{---------------------------------}}

{{--            --}}{{---------------------------------}}
{{--            <div class="col-lg-4 col-sm-6 mb-4">--}}
{{--                <a href="{{route('admin.cashMovement')}}">--}}
{{--                    <div class="content  d-flex align-items-center justify-content-center">--}}
{{--                        <div class="text-i">--}}
{{--                            <div class="w-100 mb-3 d-flex align-items-center justify-content-center">--}}
{{--                                <i class="fa fa-gamepad"></i>--}}
{{--                            </div>--}}

{{--                            <h3>--}}
{{--                                حركة النقدية--}}
{{--                            </h3>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </a>--}}

{{--            </div>--}}
{{--            --}}{{---------------------------------}}

{{--            --}}{{---------------------------------}}
{{--            <div class="col-lg-4 col-sm-6 mb-4">--}}
{{--                <a href="{{route('admin.allAccountStatement')}}">--}}
{{--                    <div class="content  d-flex align-items-center justify-content-center">--}}
{{--                        <div class="text-i">--}}
{{--                            <div class="w-100 mb-3 d-flex align-items-center justify-content-center">--}}
{{--                                <i class="fa fa-keyboard"></i>--}}
{{--                            </div>--}}

{{--                            <h3>--}}
{{--                                كشف الحساب--}}
{{--                            </h3>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </a>--}}

{{--            </div>--}}
{{--            --}}{{---------------------------------}}


{{--            --}}{{---------------------------------}}
{{--            <div class="col-lg-4 col-sm-6 mb-4">--}}
{{--                <a href="{{route('admin.openingBalances.index')}}">--}}
{{--                    <div class="content  d-flex align-items-center justify-content-center">--}}
{{--                        <div class="text-i">--}}
{{--                            <div class="w-100 mb-3 d-flex align-items-center justify-content-center">--}}
{{--                                <i class="fa fa-magic"></i>--}}
{{--                            </div>--}}

{{--                            <h3>--}}
{{--                                الأرصدة الإفتتاحية--}}
{{--                            </h3>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </a>--}}

{{--            </div>--}}
{{--            --}}{{---------------------------------}}

{{--            --}}{{---------------------------------}}
{{--            <div class="col-lg-4 col-sm-6 mb-4">--}}
{{--                <a href="{{route('admin.sanadSarfConfirmedList')}}">--}}
{{--                    <div class="content  d-flex align-items-center justify-content-center">--}}
{{--                        <div class="text-i">--}}
{{--                            <div class="w-100 mb-3 d-flex align-items-center justify-content-center">--}}
{{--                                <i class="fa fa-check"></i>--}}
{{--                            </div>--}}

{{--                            <h3>--}}
{{--                                سندات الصرف المؤكدة--}}
{{--                            </h3>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </a>--}}

{{--            </div>--}}
{{--            --}}{{---------------------------------}}

{{--            --}}{{---------------------------------}}
{{--            <div class="col-lg-4 col-sm-6 mb-4">--}}
{{--                <a href="{{route('admin.NormalSandQabdReport')}}">--}}
{{--                    <div class="content  d-flex align-items-center justify-content-center">--}}
{{--                        <div class="text-i">--}}
{{--                            <div class="w-100 mb-3 d-flex align-items-center justify-content-center">--}}
{{--                                <i class="fa fa-dollar-sign"></i>--}}
{{--                            </div>--}}

{{--                            <h3>--}}
{{--                                ترحيل سندات القبض--}}
{{--                            </h3>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </a>--}}

{{--            </div>--}}
{{--            --}}{{---------------------------------}}

{{--            --}}{{---------------------------------}}
{{--            <div class="col-lg-4 col-sm-6 mb-4">--}}
{{--                <a href="{{route('admin.sanadQabdConfirmedList')}}">--}}
{{--                    <div class="content  d-flex align-items-center justify-content-center">--}}
{{--                        <div class="text-i">--}}
{{--                            <div class="w-100 mb-3 d-flex align-items-center justify-content-center">--}}
{{--                                <i class="fa fa-check"></i>--}}
{{--                            </div>--}}

{{--                            <h3>--}}
{{--                                سندات القبض المؤكدة--}}
{{--                            </h3>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </a>--}}

{{--            </div>--}}
{{--            --}}{{---------------------------------}}


        </div>

    </section>
@endsection
