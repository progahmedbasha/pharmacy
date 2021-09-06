@extends('doctor.layouts.header')

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
</head>

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
                                            <li><span class="bread-blod">{{ __('adminmenu.dashboard') }}</span>
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

     <div id="chartContainer" style="height: 370px; width: 100%;"></div>

<div id="chartContainer2" style="height: 370px; width: 100%;"></div>


            </div>
        </div>


    @endsection

    