
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
                
                <!-----------------------end filters----------------------------->

					<!--begin: Datatable -->
					<table class="table table-striped- table-bordered table-hover table-checkable" id="basicExample">
						<thead>
							<tr>
								<th>الإسم</th>
                                <th>رقم الهاتف</th>
                                <th>الإيميل</th>
								<th>العنوان</th>
								<th>الرسالة</th>
								<th>الحالة</th>

								<th>{{__('messages.Actions')}}</th>
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
                {"data": "name",   orderable: true,searchable: true},
                {"data": "phone",   orderable: true,searchable: true},
                {"data": "email",   orderable: true,searchable: true},
                {"data": "subject",   orderable: true,searchable: true},
                {"data": "message",   orderable: true,searchable: true},
                {"data": "status",   orderable: true,searchable: true},
                {"data": "actions",   orderable: false,searchable: false}
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
                [2, "desc"]
            ],
        });
        
        $('.service_id, .client_id, .driver_id, .start, .end').change(function(){
            table.draw();
        });
        
       
        
</script>
@endsection