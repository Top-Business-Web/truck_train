
@extends('Admin.mainFrame')
@section('content')
	<div class="m-grid__item m-grid__item--fluid m-wrapper">

        <!-- BEGIN: Subheader -->
    	<div class="m-subheader ">
    		<div class="d-flex align-items-center">
    			<div class="mr-auto">
    				<h3 class="m-subheader__title m-subheader__title--separator">{{__('messages.AllAdmins')}}</h3>
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

					<!-- END: Subheader -->
					<div class="m-content">
						
						<div class="m-portlet m-portlet--mobile">
							<div class="m-portlet__head">
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<h3 class="m-portlet__head-text">
											{{__('messages.AllAdmins')}}
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
									<thead>
										<tr>
											<th>{{__('messages.title')}}</th>
											<th>{{__('messages.Email')}}</th>
											<th>{{__('messages.phone')}}</th>
											<th>{{__('messages.logo')}}</th>
											
											<th>{{__('messages.Actions')}}</th>
										</tr>
									</thead>
									<tbody>
                                        @foreach($settings as $row)
										<tr>
											<td>{{$row->title}}</td>
											<td>{{$row->email1}}</td>
											<td>{{$row->phone1}}</td>
											<td><img src="{{ Storage::url('uploads/'.$row->header_logo)}}" style="width: 150px;" /></td>
											
											<td nowrap>
                                                <a href="{{route('editSettings', $row->id)}}" class="btn btn-info">{{__('messages.Edit')}}</a>
                                                
                                            </td>
										</tr>
                                        @endforeach
										
										
									</tbody>
								</table>
                                {{ $settings->links()}}
							</div>
						</div>

						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
				</div>
	
@endsection('content')