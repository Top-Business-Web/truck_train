
@extends('Admin.mainFrame')
@section('content')
	<div class="m-grid__item m-grid__item--fluid m-wrapper">

        <!-- BEGIN: Subheader -->
    	<div class="m-subheader ">
    		<div class="d-flex align-items-center">
    			<div class="mr-auto">
    				<h3 class="m-subheader__title m-subheader__title--separator">{{__('messages.DriversRequests')}}</h3>
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
								{{__('messages.DriversRequests')}}
							</h3>
						</div>
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
								<th>{{__('messages.driverName')}}</th>
                                <th>{{__('messages.service')}}</th>
								<th>{{__('messages.national_id_num')}}</th>
                                <th>{{__('messages.vehicle_id_num')}}</th>
								<th>{{__('messages.phone')}}</th>
                                @if (isset($show_rate) && ($show_rate === true))
                                    <th>{{__('messages.rate')}}</th>
                                    <th>{{__('messages.rateDetails')}}</th>
                                    <th>{{__('messages.status')}}</th>
                                @endif

                                <th>{{__('messages.Actions')}}</th>
							</tr>
						</thead>
						<tbody>
                            @forelse($users as $user)
							<tr>
								<td>{{$user->name}}</td>
                                <td>{{$user->user_service['service_data']['title']}}</td>
                                <td>{{$user->user_details['national_id_num']}}</td>
                                <td>{{$user->user_details['vehicle_id_num']}}</td>
                                <td>{{$user->phone_code . $user->phone}}</td>
                                @if(isset($show_rate) && ($show_rate === true))
                                    <td>{{$user->rate}}</td>
                                    <td><a href="{{route('driverRates', $user->id)}}" class="btn btn-success">{{__('messages.rateDetails')}}</a></td>
                                    @if($user->is_block == 'yes')
                                        <td><a href="{{route('unblockThisDriver', $user->id)}}" class="btn btn-warning">{{__('messages.unblockDriver')}}</a></td>
                                    @elseif($user->is_block == 'no')
                                        <td><a href="{{route('blockThisDriver', $user->id)}}" class="btn btn-danger">{{__('messages.blockDriver')}}</a></td>
                                    @endif
                                @endif


                                <td nowrap>
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#details_modal_{{$user->id}}">{{__('messages.details')}}</button>
                                    @if($showActions)
                                        <a href="{{route("approveDriver",$user->id)}}" class="btn btn-success">{{__('messages.accept_driver')}}</a>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#m_modal_{{$user->id}}">{{__('messages.refuse_driver')}}</button>
                                    @endif
                                </td>

                            </tr>

                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">{{__('messages.no_data')}}</td>
                                </tr>

                            @endforelse
						</tbody>
					</table>
                    {{$users->links()}}
				</div>
			</div>

			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
    </div>


    @foreach($users as $user)

    <!--begin::Details Modal-->
    <div class="modal fade" id="details_modal_{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">{{__('messages.details')}}</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
              <table class="table table-bordered m-table">
                <thead>

                </thead>
                <tbody>

                  <tr>
                    <td>{{__('messages.driverName')}}</td>
                    <td>{{$user->name}}</td>
                  </tr>

                  <tr>
                    <td>{{__('messages.Email')}}</td>
                    <td>{{$user->email}}</td>
                  </tr>

                  <tr>
                    <td>{{__('messages.phone')}}</td>
                    <td>{{$user->phone_code . $user->phone}}</td>
                  </tr>

                  <tr>
                    <th>{{__('messages.service')}}</th>
                    <td>{{$user->user_service['service_data']['title']}}</td>
                  </tr>

                  <tr>
                    <td>{{__('messages.form_expiry_date')}}</td>
                    <td>{{$user->user_details['form_expiry_date']}}</td>
                  </tr>

                  <tr>
                    <td>{{__('messages.insurance_expiry_date')}}</td>
                    <td>{{$user->user_details['insurance_expiry_date']}}</td>
                  </tr>

                  <tr>
                    <td>{{__('messages.national_id_num')}}</td>
                    <td>{{$user->user_details['national_id_num']}}</td>
                  </tr>
                  <tr>
                    <td>{{__('messages.vehicle_id_num')}}</td>
                    <td>{{$user->user_details['vehicle_id_num']}}</td>
                  </tr>

                  <tr>
                    <td>{{__('messages.logo')}}</td>
                    <td><img src="{{Storage::url('uploads/'.$user->logo)}}" width="150" /></td>
                  </tr>

                  <tr>
                    <td>{{__('messages.residency_photo')}}</td>
                    <td><img src="{{Storage::url('uploads/'.$user->user_details['residency_photo'])}}" width="150"/></td>
                  </tr>

                  <tr>
                    <td>{{__('messages.form_photo')}}</td>
                    <td><img src="{{Storage::url('uploads/'.$user->user_details['form_photo'])}}" width="150" /></td>
                  </tr>

                  <tr>
                    <td>{{__('messages.insurance_photo')}}</td>
                    <td><img src="{{Storage::url('uploads/'.$user->user_details['insurance_photo'])}}" width="150" /></td>
                  </tr>



                </tbody>
        </table>
      </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('messages.close')}}</button>
          </div>

        </div>
      </div>
    </div>
                <!--end::Details Modal-->

                <!--begin::Refuse Modal-->
				<div class="modal fade" id="m_modal_{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-sm" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">{{__('messages.refuse_reason')}}</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
                            <form method="post" action="{{route('refuseReason')}}">
                                @csrf
							   <div class="modal-body">
									<div class="form-group">
										<label for="recipient-name" class="form-control-label">{{__('messages.reason')}}:</label>
                                        <textarea class="form-control" id="message-text" name="reason"></textarea>
										<input type="hidden" name="driver_id" value="{{ $user->id}}" />
									</div>
								<button type="submit" class="btn btn-primary">{{__('messages.Request')}}</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('messages.Cancel')}}</button>

							   </div>
								<div class="modal-footer">

								</div>
                            </form>
						</div>
					</div>
				</div>

               <!--end::Refuse Modal-->
                @endforeach

@endsection('content')
