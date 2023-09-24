@extends('Admin.mainFrame')
@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">

        <!-- BEGIN: Subheader -->
    	<div class="m-subheader ">
    		<div class="d-flex align-items-center">
    			<div class="mr-auto">
    				<h3 class="m-subheader__title m-subheader__title--separator">{{__('messages.AdminsForm')}}</h3>
    				<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
    					<li class="m-nav__item m-nav__item--home">
    						<a href="{{route('dashboard')}}" class="m-nav__link m-nav__link--icon">
    							<i class="m-nav__link-icon la la-home"></i>
    						</a>
    					</li>
    					<li class="m-nav__separator">-</li>
    					<li class="m-nav__item">
    						<a href="{{route('AllUsers')}}" class="m-nav__link">
    							<span class="m-nav__link-text">{{__('messages.AllAdmins')}}</span>
    						</a>
    					</li>
    					
    				</ul>
    			</div>
    			
    		</div>
    	</div>

        <!-- END: Subheader -->
		<div class="m-content">
			<div class="row">
				<div class="col-lg-12">
					<!--begin::Portlet-->
					<div class="m-portlet">
						<div class="m-portlet__head">
							<div class="m-portlet__head-caption">
								<div class="m-portlet__head-title">
									<span class="m-portlet__head-icon m--hide">
										<i class="la la-gear"></i>
									</span>
									<h3 class="m-portlet__head-text">
                                        {{__('messages.AdminsForm')}}
									</h3>
								</div>
							</div>
						</div>

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

						<!--begin::Form-->
						<form class="m-form" method="post" action="{{route('updateAdmin')}}" enctype="multipart/form-data">
                            @csrf
							<div class="m-portlet__body">
								<div class="m-form__section m-form__section--first">
									<div class="form-group m-form__group row">
										<label class="col-lg-3 col-form-label">{{__('messages.Username')}}:</label>
										<div class="col-lg-6">
											<input value="{{$user->name}}" type="text" class="form-control m-input" placeholder="{{__('messages.Enter full name')}}" name="name">
											@error('name')
                                                <span class="m-form__help text-danger">{{$message}}</span>
                                            @enderror
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label class="col-lg-3 col-form-label">{{__('messages.Email')}}:</label>
										<div class="col-lg-6">
											<input value="{{$user->email}}" type="email" class="form-control m-input"  name="email">
											@error('email')
                                                <span class="m-form__help text-danger">{{$message}}</span>
                                            @enderror
										</div>
									</div>
                                    
                                    <div class="form-group m-form__group row">
										<label class="col-lg-3 col-form-label">{{__('messages.Password')}}:</label>
										<div class="col-lg-6">
											<input type="password"  class="form-control m-input"  name="password">
											@error('password')
                                                <span class="m-form__help text-danger">{{$message}}</span>
                                            @enderror
										</div>
									</div>
                                    
                                    <div class="form-group m-form__group row">
										<label class="col-lg-3 col-form-label">{{__('messages.phone')}}:</label>
										<div class="col-lg-6">
											<input value="{{$user->phone}}" type="text" class="form-control m-input" name="phone" />
											@error('phone')
                                                <span class="m-form__help text-danger">{{$message}}</span>
                                            @enderror
										</div>
									</div>
                                    
                                    <div class="form-group m-form__group row">
										<label class="col-lg-3 col-form-label">{{__('messages.logo')}}:</label>
										<div class="col-lg-6">
											<input id="ImgInput" name="logo" class="form-control dropify" type="file" data-default-file="{{Storage::url('uploads/'.$user->logo)}}" />
                                        
											@error('logo')
                                                <span class="m-form__help text-danger">{{$message}}</span>
                                            @enderror
										</div>
                                        
                                        
									</div>
                                    
                                
									
								</div>
							</div>
                            <input type="hidden" name="id" value="{{$user->id}}" />
							<div class="m-portlet__foot m-portlet__foot--fit">
								<div class="m-form__actions m-form__actions">
									<div class="row">
										<div class="col-lg-3"></div>
										<div class="col-lg-6">
											<button type="submit" class="btn btn-success">{{__('messages.submit')}}</button>
											<button type="reset" class="btn btn-secondary">{{__('messages.Cancel')}}</button>
										</div>
									</div>
								</div>
							</div>
						</form>

						<!--end::Form-->
					</div>

					<!--end::Portlet-->
				</div>
				
			</div>
			
		</div>
</div>
	

@endsection('content')