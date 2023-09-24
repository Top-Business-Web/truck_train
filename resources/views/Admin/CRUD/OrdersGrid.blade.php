
@extends('Admin.mainFrame')

@section('style')
<style>
.btn-group{
    float: left;
}
</style>
@endsection
@section('content')
	<div class="m-grid__item m-grid__item--fluid m-wrapper">

        <!-- BEGIN: Subheader -->
    	<div class="m-subheader ">
    		<div class="d-flex align-items-center">
    			<div class="mr-auto">
    				<h3 class="m-subheader__title m-subheader__title--separator">{{$page_title}}</h3>
    				<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
    					<li class="m-nav__item m-nav__item--home">
    						<a href="{{route('dashboard')}}" class="m-nav__link m-nav__link--icon">
    							<i class="m-nav__link-icon la la-home"></i>
    						</a>
    					</li>

    				</ul>
    			</div>

    		</div>
    	</div>
		<!--------------------------Filter For Data------------------->


        <!-- END: Subheader -->
		<div class="m-content">
			<div class="m-portlet m-portlet--mobile">
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<h3 class="m-portlet__head-text">
								{{$page_title}}
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

                <!-----------------------start filters--------------------------->
                <form class="m-form m-form--fit m--margin-bottom-20">
					<div class="row m--margin-bottom-20">


						<div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
							<label>الخدمات:</label>
							<select class="form-control m-input service_id filter select2" name="service_id" >
								<option value="">إختر</option>
                                @foreach($services as $service)
							         <option value="{{$service->id}}" {{isset($service_id)&& $service_id ==$service->id ? 'selected':''}}>{{$service->title}}</option>
                                @endforeach

                            </select>
						</div>

                        <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
							<label>العملاء:</label>
							<select class="form-control m-input client_id filter select2" name="client_id">
								<option value="">إختر</option>
                                @foreach($clients as $client)
							         <option value="{{$client->id}}" {{isset($client_id)&& $client_id ==$client->id ? 'selected':''}}>{{$client->name.' - '.$client->phone}}</option>
                                @endforeach

                            </select>
						</div>

                        <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
							<label>السائقين:</label>
							<select class="form-control m-input driver_id filter select2" name="driver_id" >
								<option value="">إختر</option>
                                @foreach($drivers as $driver)
							         <option value="{{$driver->id}}" {{isset($driver_id)&& $driver_id ==$driver->id ? 'selected':''}}>{{$driver->name.' - '.$driver->phone}}</option>
                                @endforeach

                            </select>
						</div>



					</div>
					<div class="row m--margin-bottom-20 col-lg-6 col-md-9 col-sm-12">
                        <label>التاريخ:</label>
						<div class="input-daterange input-group" id="m_datepicker_5">
							<input type="text" class="form-control m-input start" name="start" value="{{isset($start)?$start:old('start')}}">
							<div class="input-group-append">
								<span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
							</div>
							<input type="text" class="form-control end" name="end" value="{{isset($end)?$end:old('end')}}">
						</div>

					</div>
					<div class="m-separator m-separator--md m-separator--dashed"></div>

				</form>
                <!-----------------------end filters----------------------------->

					<!--begin: Datatable -->
					<table class="table table-striped- table-bordered table-hover table-checkable" id="basicExample">
						<thead>
							<tr>
								<th>{{__('messages.orderId')}}</th>
                                <th>{{__('messages.status')}}</th>
                                <th>{{__('messages.serviceName')}}</th>
								<th>{{__('messages.Username')}}</th>
								<th>{{__('messages.DriverName')}}</th>
								<th>{{__('messages.phone')}}</th>
                                <th>{{__('messages.price')}}</th>

								<th>{{__('messages.details')}}</th>
								<th>{{__('messages.Delete')}}</th>
							</tr>
						</thead>
						<tbody>


						</tbody>
					</table>

				</div>
			</div>

			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
</div>


@endsection('content')

@section('script')
<script>


        var table = $("#basicExample").DataTable({
            dom: 'Bfrtip',
            responsive: 1,
            buttons: [
            'copy', 'excel',  'print'
        ],
            /*buttons: [
                {
                    extend: 'excel',
                    text: 'Save current page',
                    exportOptions: {
                        modifier: {
                            page: 'current'
                        }
                    }
                }
            ],*/
            "processing": true,
            "lengthChange": true,
            "serverSide": true,
            "ordering": true,
            "searching": true,
            'iDisplayLength': 20,
            "ajax": {
                        url: "{{$route_url}}",
                        data: function (d) {
                            d.service_id = $('.service_id option:selected').val(),
                            d.client_id  = $('.client_id option:selected').val(),
                            d.driver_id  = $('.driver_id option:selected').val(),
                            d.start_date = $('.start').val(),
                            d.end_date   = $('.end').val()
                        }
                    },
            "columns": [
                {"data": "id",   orderable: true,searchable: true},
                {"data": "order_status",   orderable: true,searchable: true},
                {"data": "service_id",   orderable: true,searchable: true},
                {"data": "user_id",   orderable: true,searchable: true},
                {"data": "driver_id",   orderable: true,searchable: true},
                {"data": "driver_phone",   orderable: true,searchable: true},
                {"data": "order_price",   orderable: true,searchable: true},
                {"data": "actions", orderable: false, searchable: false},
                {"data": "delete", orderable: false, searchable: false}
            ],

            "language": {
                "sProcessing":   "جارى التحميل",
                "sLengthMenu":   "{{trans('admin.sLengthMenu')}}",
                "sZeroRecords":  "لايوجد بيانات للعرض",
                "sInfo":         "بيانات العرض",
                "sInfoEmpty":    "لايوجد بيانات للعرض",
                "sInfoFiltered": "بيانات البحث",
                "sInfoPostFix":  "",
                "sSearch":       "بحث:",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst":    "الأول",
                    "sPrevious": "السابق",
                    "sNext":     "التالى",
                    "sLast":     "الأخير"
                }
            },
            order: [
                [0,"desc"]
            ],
        });

        $('.service_id, .client_id, .driver_id, .start, .end').change(function(){
            table.draw();
        });



</script>
@endsection
