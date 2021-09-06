@extends('admin.layouts.header')

@section('content')

    <head>
<script>
window.onload = function() {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title: {
		text: "Market Share - 2020"
	},
	data: [{
		type: "pie",
		startAngle: 240,
		yValueFormatString: "##0.00\"%\"",
		indexLabel: "{label} {y}",
		dataPoints: [
			{y: 79.45, label: "Google"},
			{y: 7.31, label: "Bing"},
			{y: 7.06, label: "Baidu"},
			{y: 4.91, label: "Yahoo"},
			{y: 1.26, label: "Others"}
		]
	}]
});
chart.render();



var chart2 = new CanvasJS.Chart("chartContainer2", {
	animationEnabled: true,
	title:{
		text: "Sales Rate"
	},
	axisX: {
		interval: 1,
		intervalType: "year",
		valueFormatString: "YYYY"
	},
	axisY: {
		suffix: "%"
	},
	toolTip: {
		shared: true
	},
	legend: {
		reversed: true,
		verticalAlign: "center",
		horizontalAlign: "right"
	},
	data: [{
		type: "stackedColumn100",
		name: "Real-Time",
		showInLegend: true,
		xValueFormatString: "YYYY",
		yValueFormatString: "#,##0\"%\"",
		dataPoints: [
			{ x: new Date(2020,0), y: 72 },
			{ x: new Date(2021,0), y: 60 },
			/*{ x: new Date(2012,0), y: 60 },
			{ x: new Date(2013,0), y: 61 },
			{ x: new Date(2014,0), y: 63 },
			{ x: new Date(2015,0), y: 65 },
			{ x: new Date(2016,0), y: 67 }*/
		]
	},
	{
		type: "stackedColumn100",
		name: "Web Browsing",
		showInLegend: true,
		xValueFormatString: "YYYY",
		yValueFormatString: "#,##0\"%\"",
		dataPoints: [
			{ x: new Date(2020,0), y: 28 },
			{ x: new Date(2021,0), y: 40 },
			/*{ x: new Date(2012,0), y: 12 },
			{ x: new Date(2013,0), y: 10 },
			{ x: new Date(2014,0), y: 10 },
			{ x: new Date(2015,0), y: 7 },
			{ x: new Date(2016,0), y: 5 }*/
		]
	}/*,
	{
		type: "stackedColumn100",
		name: "File Sharing",
		showInLegend: true,
		xValueFormatString: "YYYY",
		yValueFormatString: "#,##0\"%\"",
		dataPoints: [
			{ x: new Date(2010,0), y: 15 },
			{ x: new Date(2011,0), y: 12 },
			{ x: new Date(2012,0), y: 10 },
			{ x: new Date(2013,0), y: 9 },
			{ x: new Date(2014,0), y: 7 },
			{ x: new Date(2015,0), y: 5 },
			{ x: new Date(2016,0), y: 1 }
		]
	},
	{
		type: "stackedColumn100",
		name: "Others",
		showInLegend: true,
		xValueFormatString: "YYYY",
		yValueFormatString: "#,##0\"%\"",
		dataPoints: [
			{ x: new Date(2010,0), y: 17 },
			{ x: new Date(2011,0), y: 20 },
			{ x: new Date(2012,0), y: 18 },
			{ x: new Date(2013,0), y: 20 },
			{ x: new Date(2014,0), y: 20 },
			{ x: new Date(2015,0), y: 23 },
			{ x: new Date(2016,0), y: 27 }
		]
	}*/]
});
chart2.render();

}
</script>


<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

    <style>


        .mb-3, .my-3 {
            margin-bottom: 1rem !important;
        }

        .mt-3, .my-3 {
            margin-top: 1rem !important;
        }
        .main-dash {
            background-image: url({{url('newStyle/imege.jpg')}});
            background-size: cover;
            background-attachment: fixed;
        }

        .main-dash .contents {
            position: relative;
            background-color: #212b35;
            font-size: 28px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            padding: 30px 15px;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            border-radius: 16px;
            -ms-flex-pack: distribute;
            justify-content: space-around;
        }

        .main-dash .contents .top-img {
            position: absolute;
            top: -15px;
            right: 0px;
            background: #212b35;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
        }

        .main-dash .contents .top-img i {
            color: #fff;
        }

        .main-dash .contents .title {
            color: #fa7510;
            font-weight: bold;
        }

        .main-dash .contents .num {
            color: #fff;
            font-weight: bold;
            z-index: 1;
        }

        .main-dash .more {
            position: absolute;
            background-color: #212b35;
            border-radius: 4px;
            padding: 2px 6px;
            left: 15px;
            bottom: -14px;
        }

        .main-dash .more a {
            color: #fff;
            -webkit-transform: .3s;
            transform: .3s;
        }

        .main-dash .more a:hover {
            color: #fa7510;
        }

        .main-dash .more i {
            color: #fff;
        }

        .main-dash .contents-repo {
            position: relative;
            background-color: #2d003b;
            font-size: 28px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            padding: 20px 15px;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            border-radius: 16px;
            -ms-flex-pack: distribute;
            justify-content: space-around;
        }

        .main-dash .contents-repo .top-img {
            position: absolute;
            top: -15px;
            right: 0px;
            background: #2d003b;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
        }

        .main-dash .contents-repo .title {
            color: #ffffff;
            font-weight: bold;
            font-size: 20px;
        }

        .main-dash .contents-repo .img {
            color: #fff;
            font-weight: bold;
            z-index: 1;
        }

        .main-dash .contents-box {
            position: relative;
            background-color: #fe7503;
            font-size: 28px;
            width: 100%;
            height: 100%;
            padding: 20px 15px;
        }

        .main-dash .contents-box .title {
            color: #ffffff;
            font-weight: bold;
            font-size: 20px;
            text-align: center;
        }

        .main-dash .contents-box .img {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
        }

        .main-dash .contents-box .img i {
            color: #fff;
        }

        .main-dash .contents-last {
            position: relative;
            background-color: #ec2124;
            font-size: 28px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            padding: 20px 15px;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            border-radius: 16px;
            -ms-flex-pack: distribute;
            justify-content: space-around;
        }

        .main-dash .contents-last .title {
            color: #ffffff;
            font-weight: bold;
            font-size: 20px;
        }

        .main-dash .contents-last .img {
            color: #fff;
            font-weight: bold;
            z-index: 1;
        }

        .main-dash .contents:hover,
        .main-dash .contents-repo:hover,
        .main-dash .contents-box:hover,
        .main-dash .contents-last:hover {
            -webkit-box-shadow: 0px 0px 15px rgba(39, 39, 39, 0.801);
            box-shadow: 0px 0px 15px rgba(39, 39, 39, 0.801);
        }
    </style>
    <link href="{{url('newStyle')}}/bootstrap-rtl.css" rel="stylesheet">
</head>

{{--          <div class="breadcome-area">--}}
{{--                <div class="container-fluid">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">--}}
{{--                            <div class="breadcome-list">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">--}}
{{--                                        <ul class="breadcome-menu">--}}
{{--                                            <!--<li><a href="#">Home</a> <span class="bread-slash">/</span>--}}
{{--                                            </li>-->--}}
{{--                                            <li><span class="bread-blod">{{ __('adminmenu.dashboard') }}</span>--}}
{{--                                            </li>--}}
{{--                                        </ul>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--     --}}
{{--        <div class="analytics-sparkle-area">--}}
{{--            <div class="container-fluid">--}}

{{--     <div id="chartContainer" style="height: 370px; width: 100%;"></div>--}}

{{--<div id="chartContainer2" style="height: 370px; width: 100%;"></div>--}}


{{--            </div>--}}
{{--        </div>--}}




<section class="main-dash pt-5" id="ContentChange">
    <div class="container">
        <div class="row px-md-5 pt-5" style="padding-top: 50px;">
            <div class="col-lg-4 col-md-6 mb-3">
                <a class="contents" href="">

                    <div class="top-img">
                        <img src="{{url('newStyle/store.png')}}" alt="">
                    </div>
                    <span class="title"> إجمالي المنتجات </span>
                    <span class="num"> 60 </span>

                    <div class="more">
                        <a class="" href="">المزيد</a>
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>

                    </div>

                </a>

            </div>

            <div class="col-lg-4 col-md-6 mb-3">
                <a class="contents" href="">

                    <div class="top-img">
                        <i class="fa fa-hand-pointer-o" aria-hidden="true"></i>

                    </div>
                    <span class="title"> إجمالي الطلبات </span>
                    <span class="num"> 60 </span>

                    <div class="more">
                        <a class="" href="">المزيد</a>
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>

                    </div>

                </a>

            </div>


            <div class="col-lg-4 col-md-6 mb-3">
                <a class="contents" href="">

                    <div class="top-img">
                        <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>

                    </div>
                    <span class="title"> إجمالي المبيعات </span>
                    <span class="num"> 60 </span>

                    <div class="more">
                        <a class="" href="">المزيد</a>
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>

                    </div>

                </a>

            </div>
        </div>


        <div class="row pt-5" style="padding-top: 50px">
            <div class="col-lg-3 col-md-6 mb-3">
                <a class="contents-repo" href="">

                    <span class="title"> تقرير المبيعات </span>
                    <div class="img"> <img src="{{url('newStyle/report.png')}}" alt=""> </div>



                </a>

            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <a class="contents-repo" href="">


                    <span class="title"> تقرير المشتريات </span>
                    <div class="img"> <i class="fa fa-money" aria-hidden="true"></i>
                    </div>



                </a>

            </div>


            <div class="col-lg-3 col-md-6 mb-3">
                <a class="contents-repo" href="">

                    <span class="title"> حسابات العملاء</span>
                    <div class="img"><img src="{{url('newStyle/report.png')}}" alt=""> </div>



                </a>

            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <a class="contents-repo" href="">


                    <span class="title"> إستحقاقات العملاء </span>
                    <div class="img"> <i class="fa fa-credit-card" aria-hidden="true"></i>
                    </div>



                </a>

            </div>
        </div>


        <div class="row pt-5" style=" padding-top: 50px;   display: flex;
    justify-content: center;">
            <div class="col-lg-2 col-md-6 mb-3">
                <div class="contents-box" href="">
                    <a href="">
                        <div class="img"><i class="fa fa-download" aria-hidden="true"></i>
                        </div>

                        <h3 class="title mt-3"> إضافة منتجات </h3>
                    </a>




                </div>

            </div>

            <div class="col-lg-2 col-md-6 mb-3">
                <div class="contents-box" href="">
                    <a href="">
                        <div class="img"> <i class="fa fa-truck" aria-hidden="true"></i>
                        </div>

                        <h3 class="title mt-3"> إدارة المشتريات </h3>

                    </a>




                </div>

            </div>


            <div class="col-lg-2 col-md-6 mb-3">
                <div class="contents-box" href="">
                    <a href="">
                        <div class="img"> <i class="fa fa-lightbulb-o" aria-hidden="true"></i>
                        </div>

                        <h3 class="title mt-3"> إدارة المبيعات </h3>


                    </a>


                </div>

            </div>

            <div class="col-lg-2 col-md-6 mb-3">
                <div class="contents-box" href="">
                    <a href="">
                        <div class="img"> <i class="fa fa-archive" aria-hidden="true"></i>
                        </div>

                        <h3 class="title mt-3"> رصيد الخزنه </h3>

                    </a>

                </div>

            </div>

            <div class="col-lg-2 col-md-6 mb-3">
                <div class="contents-box" href="">
                    <a href="">
                        <div class="img"> <i class="fa fa-lock" aria-hidden="true"></i>
                        </div>

                        <h3 class="title mt-3"> حد الطلب من المنتجات </h3>

                    </a>




                </div>

            </div>
        </div>




        <div class="row py-5 px-5" style="padding-top: 50px ; padding-bottom: 50px ; display:  flex; justify-content: center;">
            <div class="col-lg-5 col-md-5 mb-3">
                <a class="contents-last" href="">

                    <div class="img"> <i class="fa fa-shield" aria-hidden="true"></i> </div>
                    <span class="title">   منتجات إنتهت صلاحيتها </span>



                </a>

            </div>

            <div class="col-lg-5 col-md-5 mb-3">
                <a class="contents-last" href="">


                    <div class="img"> <i class="fa fa-refresh" aria-hidden="true"></i> </div>
                    <span class="title"> مرتجع   </span>



                </a>

            </div>





        </div>



    </div>
</section>


    @endsection
@section('js')

    <script>

        $(document).ready(function (){
            if ("{{$checkModal}}" == 'yes' && localStorage.getItem('showModal') == null){
                localStorage.setItem('showModal','first')
            }

            if (localStorage.getItem('showModal') == 'first'){
                localStorage.setItem('showModal','yes')
                $('#ContentChange').load("{{url("getProductsAlarm")}}")
            }
        })
    </script>
@endsection

