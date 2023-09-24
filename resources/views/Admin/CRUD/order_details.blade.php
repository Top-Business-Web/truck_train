
@extends('Admin.mainFrame')
@section('content')
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

<style type="text/css">
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }

      
    </style>
{{--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAeyMUJgKAhnNXbILHONb1um72CNzELFRY"></script>--}}
{{--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAQQKiQuIKyYbneD8AtnfJ00mgCeBkhMEU"></script>--}}

<script src="http://maps.google.com/maps/api/js?key=AIzaSyAeyMUJgKAhnNXbILHONb1um72CNzELFRY&libraries=places"
        type="text/javascript"></script>
	<div class="m-grid__item m-grid__item--fluid m-wrapper">

        <!-- BEGIN: Subheader -->
    	<div class="m-subheader ">
    		<div class="d-flex align-items-center">
    			<div class="mr-auto">
    				<h3 class="m-subheader__title m-subheader__title--separator">{{__('messages.orderDetails')}}</h3>
    				<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
    					<li class="m-nav__item m-nav__item--home">
    						<a href="{{route('dashboard')}}" class="m-nav__link m-nav__link--icon">
    							<i class="m-nav__link-icon la la-home"></i>
    						</a>
    					</li>
                        <li class="m-nav__separator">-</li>
    					<li class="m-nav__item">
    						<a href="{{route('AllNewOrders')}}" class="m-nav__link">
    							<span class="m-nav__link-text">{{__('messages.AllOrders')}}</span>
    						</a>
    					</li>
    					
    				</ul>
    			</div>
    			
    		</div>
    	</div>

        <!-- END: Subheader -->
		<div class="m-content">
			
			<div class="m-portlet m-portlet--mobile">
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<h3 class="m-portlet__head-text">
								{{__('messages.orderDetails')}}
							</h3>
						</div>
					</div>
					<div class="m-portlet__head-tools">
						
					</div>
				</div>
				<div class="m-portlet__body">
                
                @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show " role="alert">
                    <p class="text-center">
                      {{Session::get('success')}}
                      </p>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                @endif

					<!--begin: Datatable -->
					<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
						<tbody>
                            <tr>
                                <td>{{__('messages.orderId')}}</td>
                                <td>{{$order->id}}</td>
                            </tr>
                            <tr>
                                <td>{{__('messages.status')}}</td>
                                <td>
                                    @if($order->order_status == 'new_order')
                                        <span class="badge badge-success">{{ __('messages.new_order')}}</span>
                                    @elseif($order->order_status == 'drivers_not_found')
                                        <span class="badge badge-warning">{{ __('messages.drivers_not_found')}}</span>
                                    @elseif($order->order_status == 'all_drivers_refuse')
                                        <span class="badge badge-danger">{{ __('messages.all_drivers_refuse')}}</span>
                                    @elseif($order->order_status == 'client_refuse_all_offers')
                                        <span class="badge badge-danger">{{ __('messages.client_refuse_all_offers')}}</span>
                                    @elseif($order->order_status == 'shipment_order')
                                        <span class="badge badge-success">{{ __('messages.shipment_order')}}</span>
                                    @elseif($order->order_status == 'client_select_driver')
                                        <span class="badge badge-info">{{ __('messages.client_select_driver')}}</span>
                                    @elseif($order->order_status == 'delivery_order')
                                        <span class="badge badge-info">{{ __('messages.delivery_order')}}</span>
                                    @elseif($order->order_status == 'end_delivered')
                                        <span class="badge badge-info">{{ __('messages.end_delivered')}}</span>
                                    @elseif($order->order_status == 'client_rate_driver')
                                        <span class="badge badge-success">{{ __('messages.client_rate_driver')}}</span>
                                    @elseif($order->order_status == 'client_cancel_order')
                                        <span class="badge badge-warning">{{ __('messages.client_cancel_order')}}</span>
                                    @elseif($order->order_status == 'driver_cancel_order')
                                        <span class="badge badge-danger">{{ __('messages.driver_cancel_order')}}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{__('messages.serviceName')}}</td>
                                <td>{{$order->service['title']}}</td>
                            </tr>
                            <tr>
                                <td>{{__('messages.Username')}}</td>
								<td>{{$order->user_data['name']}}</td>
                            </tr>
                            <tr>
                                <td>{{__('messages.DriverName')}}</td>
								<td>{{$order->driver_data['name']}}</td>
                            </tr>
                            
                            <tr>
                                <td>{{__('messages.phone')}}</td>
                                <td>{{$order->phone}}</td>
                            </tr>
                            
                            <tr>
                                <td>{{__('messages.price')}}</td>
								<td>{{$order->order_price}}</td>
                            </tr>
                            
                            <tr>
                                <td>{{__('messages.order_time')}}</td>
								<td>{{$order->order_time}}</td>
                            </tr>
                            
                            <tr>
                                <td>{{__('messages.order_date')}}</td>
								<td>{{$order->order_date}}</td>
                            </tr>
                            
                            <tr>
                                <td>{{__('messages.from_address')}}</td>
								<td>{{$order->from_address}}</td>
                            </tr>
                            
                            <tr>
                                <td>{{__('messages.to_address')}}</td>
								<td>{{$order->to_address}}</td>
                            </tr>
                            
{{--                            <tr>--}}
{{--                                <td>{{__('messages.map')}}</td>--}}
{{--                                <td>--}}
{{--                                     <div id="map" style="min-width: 550px; min-height: 400px;"></div>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
                        <tr>
                            <td>{{__('messages.map')}}</td>
                            <td>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div id="map" style="width:100%; height:400px;"></div>
                                </div>
                            </td>
                        </tr>
                            
                            
							
							
						</tbody>
					</table>
				</div>
			</div>

			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
				</div>
                
                <div id="floating-panel" style="display: none;">
      <b>Mode of Travel: </b>
      <select id="mode">
        <option value="DRIVING">Driving</option>
        <option value="WALKING">Walking</option>
        <option value="BICYCLING">Bicycling</option>
        <option value="TRANSIT">Transit</option>
      </select>
    </div>


@endsection('content')

@section('script')
    <script type="text/javascript">
        var from_lat = "{{$order->from_latitude}}";
        var from_long = "{{$order->from_longitude}}";

        var to_long = "{{$order->to_longitude}}";
        var to_lat = "{{$order->to_latitude}}";
        var locations = [
            ['من هذا الموقع ', parseFloat(from_lat), parseFloat(from_long), 5],
            ['الى هذا الموقع ', parseFloat(to_lat), parseFloat(to_long), 5],
            // ['Cronulla Beach', -34.028249, 151.157507, 3],
            // ['Manly Beach', -33.80010128657071, 151.28747820854187, 2],
            // ['Maroubra Beach', -33.950198, 151.259302, 1]
        ];

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 6,
            center: new google.maps.LatLng(parseFloat(from_lat), parseFloat(from_long)),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var infowindow = new google.maps.InfoWindow();

        var marker, i;

        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map
            });

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow.setContent(locations[i][0]);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }


    </script>
@endsection