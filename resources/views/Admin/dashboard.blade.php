
@extends('Admin.mainFrame')
@section('content')

    @once
        @push('styles')

        @endpush

        @push('scripts')

    		<!--end::Page Vendors -->

    		<!--begin::Page Scripts -->

        @endpush
    @endonce


    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>


    <script src="//www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="//www.amcharts.com/lib/3/serial.js"></script>
    <script src="//www.amcharts.com/lib/3/themes/light.js"></script>

    <div class="m-grid__item m-grid__item--fluid m-wrapper">

        <!-- BEGIN: Subheader -->
    	<div class="m-subheader ">
    		<div class="d-flex align-items-center">
    			<div class="mr-auto">

    			</div>

    		</div>
    	</div>

    <div class="m-content">
        <div class="row">
            <div class="col-lg-12">

                <div class="m-portlet m-portlet--tab">
    				<div class="m-portlet__head">
    					<div class="m-portlet__head-caption">
    						<div class="m-portlet__head-title">
    							<span class="m-portlet__head-icon m--hide">
    								<i class="la la-gear"></i>
    							</span>
    							<h3 class="m-portlet__head-text">
    								{{__('messages.users_agents')}}
    							</h3>
    						</div>
    					</div>
    				</div>
    				<div class="m-portlet__body">
                        <div id="agents_div" style="height: 500px;"></div>
    				</div>
    			</div>

            </div>

            <div class="col-lg-12">

                <div class="m-portlet m-portlet--tab">
    				<div class="m-portlet__head">
    					<div class="m-portlet__head-caption">
    						<div class="m-portlet__head-title">
    							<span class="m-portlet__head-icon m--hide">
    								<i class="la la-gear"></i>
    							</span>
    							<h3 class="m-portlet__head-text">
    								{{__('messages.ordersStatuses')}}
    							</h3>
    						</div>
    					</div>
    				</div>
    				<div class="m-portlet__body">
                        <div id="order_status" style="height: 500px;"></div>
    				</div>
    			</div>

            </div>


        </div>
    </div>
</div>

    <script>



// Create agent chart
var chart = am4core.create("agents_div", am4charts.PieChart);

// Add data
chart.data = [{
  "agent": "ios",
  "users": {{$ios_users_count}}
}, {
  "agent": "android",
  "users": {{$android_users_count}}
}];

// Add and configure Series
var pieSeries = chart.series.push(new am4charts.PieSeries());
pieSeries.dataFields.value = "users";
pieSeries.dataFields.category = "agent";


var chart = AmCharts.makeChart("order_status", {
  "type": "serial",
  "theme": "light",
  "dataProvider": [{
    "status": "{{__('messages.new')}}",
    "count": {{$new_orders_count}}
  }, {
   "status": "{{__('messages.refused_orders')}}",
    "count": {{$refused_orders_count}}
  }, {
    "status": "{{__('messages.inprogress_orders')}}",
    "count": {{$inprogress_orders_count}}
  }, {
    "status": "{{__('messages.cancelled_orders')}}",
    "count": {{$cancelled_orders}}
  }, ],
  "graphs": [{
    "fillAlphas": 0.9,
    //"lineAlpha": 0.2,
    "type": "column",
    "valueField": "count"
  }],
  "categoryField": "status",
  "valueAxes": [{
    "minimum": 0
  }]
});
    </script>

@endsection('content')
