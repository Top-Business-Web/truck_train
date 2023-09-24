@extends('Admin.mainFrame')
@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">

        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title m-subheader__title--separator">{{__('messages.editSettings')}}</h3>
                    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                        <li class="m-nav__item m-nav__item--home">
                            <a href="{{route('dashboard')}}" class="m-nav__link m-nav__link--icon">
                                <i class="m-nav__link-icon la la-home"></i>
                            </a>
                        </li>
                        <li class="m-nav__separator">-</li>
                        <li class="m-nav__item">
                            <a href="{{route('AppSettings')}}" class="m-nav__link">
                                <span class="m-nav__link-text">{{__('messages.AppSettings')}}</span>
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
                                        {{__('messages.editSettings')}}
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
                        <form class="m-form" method="post" action="{{route('UpdateSettings')}}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="m-portlet__body">
                                <div class="m-form__section m-form__section--first">
                                    <div class="form-group m-form__group row">
                                        <label class="col-lg-3 col-form-label">{{__('messages.appName')}}:</label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control m-input" placeholder="" name="title"
                                                   value="{{$settings->title}}">
                                            @error('title')
                                            <span class="m-form__help text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label class="col-lg-3 col-form-label">{{__('messages.desc')}}:</label>
                                        <div class="col-lg-6">
                                            <textarea class="form-control m-input"
                                                      name="desc">{{$settings->desc}}</textarea>
                                            @error('desc')
                                            <span class="m-form__help text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label class="col-lg-3 col-form-label">{{__('messages.address')}}:</label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control m-input" placeholder=""
                                                   name="address1" value="{{$settings->address1}}">
                                            @error('address1')
                                            <span class="m-form__help text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label class="col-lg-3 col-form-label">{{__('messages.phone')}}:</label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control m-input" placeholder="" name="phone1"
                                                   value="{{$settings->phone1}}">
                                            @error('phone1')
                                            <span class="m-form__help text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label class="col-lg-3 col-form-label">{{__('messages.android_app')}}:</label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control m-input" placeholder=""
                                                   name="android_app" value="{{$settings->android_app}}">
                                            @error('android_app')
                                            <span class="m-form__help text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label class="col-lg-3 col-form-label">{{__('messages.ios_app')}}:</label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control m-input" placeholder=""
                                                   name="ios_app" value="{{$settings->ios_app}}">
                                            @error('ios_app')
                                            <span class="m-form__help text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label class="col-lg-3 col-form-label">{{__('messages.Email')}}:</label>
                                        <div class="col-lg-6">
                                            <input type="email" class="form-control m-input" placeholder=""
                                                   name="email1" value="{{$settings->email1}}"/>
                                            @error('email1')
                                            <span class="m-form__help text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label class="col-lg-3 col-form-label">{{__('messages.facebook')}}:</label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control m-input" placeholder=""
                                                   name="facebook" value="{{$settings->facebook}}"/>
                                            @error('facebook')
                                            <span class="m-form__help text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label class="col-lg-3 col-form-label">{{__('messages.twitter')}}:</label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control m-input" placeholder=""
                                                   name="twitter" value="{{$settings->twitter}}"/>
                                            @error('twitter')
                                            <span class="m-form__help text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label class="col-lg-3 col-form-label">{{__('messages.instagram')}}:</label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control m-input" placeholder=""
                                                   name="instagram" value="{{$settings->instagram}}"/>
                                            @error('instagram')
                                            <span class="m-form__help text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label class="col-lg-3 col-form-label">{{__('messages.telegram')}}:</label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control m-input" placeholder=""
                                                   name="telegram" value="{{$settings->telegram}}"/>
                                            @error('telegram')
                                            <span class="m-form__help text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label class="col-lg-3 col-form-label">{{__('messages.youtube')}}:</label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control m-input" placeholder=""
                                                   name="youtube" value="{{$settings->youtube}}"/>
                                            @error('youtube')
                                            <span class="m-form__help text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label class="col-lg-3 col-form-label">{{__('messages.whatsapp')}}:</label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control m-input" placeholder=""
                                                   name="whatsapp" value="{{$settings->whatsapp}}"/>
                                            @error('whatsapp')
                                            <span class="m-form__help text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label class="col-lg-3 col-form-label">{{__('messages.about_app')}}:</label>
                                        <div class="col-lg-6">
											<textarea name="about_app" rows="10" class="form-control m-input" >{{$settings->about_app}}</textarea>
                                          {{--  <input type="text" placeholder=""
                                                    value=""/>--}}
                                            @error('about_app')
                                            <span class="m-form__help text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label class="col-lg-3 col-form-label">{{__('messages.ar_termis_condition')}}
                                            :</label>
                                        <div class="col-lg-6">
                                            <textarea class="form-control m-input" rows="10"
                                                      name="ar_termis_condition">{{$settings->ar_termis_condition}}</textarea>

                                            @error('ar_termis_condition')
                                            <span class="m-form__help text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label class="col-lg-3 col-form-label">{{__('messages.en_termis_condition')}}
                                            :</label>
                                        <div class="col-lg-6">
                                            <textarea class="form-control m-input"
                                                      name="en_termis_condition">{{$settings->en_termis_condition}}</textarea>

                                            @error('en_termis_condition')
                                            <span class="m-form__help text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="form-group m-form__group row">
                                        <label class="col-lg-3 col-form-label">{{__('messages.Image')}}:</label>
                                        <div class="col-lg-6">
                                            <input type="file" class="form-control m-input dropify" name="image"
                                                   data-default-file="{{Storage::url('uploads/'.$settings->header_logo)}}"/>
                                            @error('image')
                                            <span class="m-form__help text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <input name="id" value="{{$settings->id}}" type="hidden"/>

                                </div>
                            </div>
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions m-form__actions">
                                    <div class="row">
                                        <div class="col-lg-3"></div>
                                        <div class="col-lg-6">
                                            <button type="submit"
                                                    class="btn btn-success">{{__('messages.submit')}}</button>
                                            <button type="reset"
                                                    class="btn btn-secondary">{{__('messages.Cancel')}}</button>
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
