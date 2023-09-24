
@extends('Admin.mainFrame')
@section('content')
    
	<div class="m-grid__item m-grid__item--fluid m-wrapper">

        <!-- BEGIN: Subheader -->
    	<div class="m-subheader ">
    		<div class="d-flex align-items-center">
    			<div class="mr-auto">
    				<h3 class="m-subheader__title m-subheader__title--separator">تفاصيل الرسالة</h3>
    				<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
    					<li class="m-nav__item m-nav__item--home">
    						<a href="{{route('dashboard')}}" class="m-nav__link m-nav__link--icon">
    							<i class="m-nav__link-icon la la-home"></i>
    						</a>
    					</li>
                        <li class="m-nav__separator">-</li>
    					<li class="m-nav__item">
    						<a href="{{route('Contact_us_messages')}}" class="m-nav__link">
    							<span class="m-nav__link-text">كل الرسائل</span>
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
								تفاصيل الرسالة
							</h3>
						</div>
					</div>
					<div class="m-portlet__head-tools">
						
					</div>
				</div>
				<div class="m-portlet__body">
                
              

					<!--begin: Datatable -->
					<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
						<tbody>
                           
                            <tr>
                                <td>الإسم</td>
                                <td>{{$msg_data->name}}</td>
                            </tr>
                            <tr>
                                <td>الإيميل</td>
								<td>{{$msg_data->email}}</td>
                            </tr>
                            <tr>
                                <td>رقم الهاتف</td>
								<td>{{$msg_data->phone}}</td>
                            </tr>
                            
                            <tr>
                                <td>الموضوع</td>
                                <td>{{$msg_data->subject}}</td>
                            </tr>
                            
                            <tr>
                                <td>الرسالة</td>
								<td>{{$msg_data->message}}</td>
                            </tr>
                            
                            <tr>
                                <td>تاريخ الإرسال</td>
								<td>{{$msg_data->created_at}}</td>
                            </tr>
                            
                           
						</tbody>
					</table>
				</div>
			</div>

			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
</div>
                
                
@endsection('content')