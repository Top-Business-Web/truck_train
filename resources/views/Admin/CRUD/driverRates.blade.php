
@extends('Admin.mainFrame')
@section('content')
	<div class="m-grid__item m-grid__item--fluid m-wrapper">

        <!-- BEGIN: Subheader -->
    	<div class="m-subheader ">
    		<div class="d-flex align-items-center">
    			<div class="mr-auto">
    				<h3 class="m-subheader__title m-subheader__title--separator">{{__('messages.rateDetails')}}</h3>
    				<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
    					<li class="m-nav__item m-nav__item--home">
    						<a href="{{route('dashboard')}}" class="m-nav__link m-nav__link--icon">
    							<i class="m-nav__link-icon la la-home"></i>
    						</a>
    					</li>
                        
                        <li class="m-nav__separator">-</li>
    					<li class="m-nav__item">
    						<a href="{{route('AllAcceptedDrivers')}}" class="m-nav__link">
    							<span class="m-nav__link-text">{{__('messages.AllDrivers')}}</span>
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
								{{__('messages.rateDetails')}}
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
								<th>{{__('messages.Username')}}</th>
								<th>{{__('messages.comment')}}</th>
								<th>{{__('messages.rate')}}</th>
								
							</tr>
						</thead>
						<tbody>
                            @forelse($rates as $rate)
							<tr>
								<td>{{$rate->user_data['name']}}</td>
								<td>{{$rate->comment}}</td>
								<td>{{$rate->rate}}</td>
							</tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">{{__('messages.no_data')}}</td>
                            </tr>
                            @endforelse
							
							
						</tbody>
					</table>
                    {{--$rates->links()--}}
				</div>
			</div>

			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
    </div>
	
@endsection('content')