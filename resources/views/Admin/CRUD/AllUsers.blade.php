
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
									<ul class="m-portlet__nav">
										<li class="m-portlet__nav-item">
											<a href="{{route('AddAdminUser')}}" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
												<span>
													<i class="la la-plus"></i>
													<span>{{__('messages.Add')}}</span>
												</span>
											</a>
										</li>
										<li class="m-portlet__nav-item"></li>

									</ul>
								</div>
							</div>
							<div class="m-portlet__body">
								<!----------------------Filtering Data------------------>
								<form method="POST" action="{{route('user.search')}}">
									@csrf
									<div class="row">
										<div class="form-group col-sm-3">
											<label>{{__('messages.UsernameChoice')}}:</label>
											<select name="user_id" class="form-control selectpicker m-input title area_place_cls search" data-live-search='true' data-validation='required' aria-required='true'>
												<option value="" disabled selected> {{__('messages.Username')}}:</option>
												@foreach($users as $user)
													<option value="{{ $user->id }}" {{$user->name == $user->id   ? 'selected' : ''}}>{{$user->name }}</option>
												@endforeach
											</select>
										</div>
										<div class="form-group col-sm-3">
											<label>{{__('messages.phoneChoice')}}:</label>
											<select name="phone_num" class="form-control selectpicker m-input title area_place_cls search" data-live-search='true' data-validation='required' aria-required='true'>
												<option value="" disabled selected> {{__('messages.phone')}}:</option>
												@foreach($users as $user)
													@if($user->phone != null || $user->phone !='')
													<option value="{{ $user->phone }}" {{$user->phone == $user->id   ? 'selected' : ''}}>{{$user->phone }}</option>
												@endif
														@endforeach
											</select>
										</div>

										<div class="form-group col-sm-3 mt-4 ">
											<input type="submit" class="btn btn-primary" value="{{__('messages.search')}}">
										</div>
									</div>
								</form>
								<!--------------------------End Filter------------------------>
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
											<th>{{__('messages.Email')}}</th>
											<th>{{__('messages.phone')}}</th>
											<th>{{__('messages.logo')}}</th>

											<th>{{__('messages.Actions')}}</th>
										</tr>
									</thead>
									<tbody>
                                        @foreach($users as $user)
										<tr>
											<td>{{$user->name}}</td>
											<td>{{$user->email}}</td>
											<td>{{$user->phone}}</td>
											<td><img src="{{ Storage::url('uploads/'.$user->logo)}}" style="width: 150px;" /></td>

											<td nowrap>
                                                <a href="{{route('editAdmin', $user->id)}}" class="btn btn-info">{{__('messages.Edit')}}</a>
                                                <a href="{{route('deleteAdmin', $user->id)}}" class="btn btn-danger">{{__('messages.Delete')}}</a>
                                            </td>
										</tr>
                                        @endforeach


									</tbody>
								</table>
                                {{$users->links()}}
							</div>
						</div>

						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
				</div>

@endsection('content')
