
@extends('Admin.mainFrame')
@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">

        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title m-subheader__title--separator">{{__('messages.Slider')}}</h3>
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
                                {{__('messages.Slider')}}
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a  data-toggle="modal" data-target="#m_modal_" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
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

                        @if(Session::has('error'))
                        <div class="alert alert-danger alert-dismissible fade show " role="alert">
                            <p class="text-center">
                                {{Session::get('error')}}
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
                            <th>{{__('messages.Image')}}</th>

                            <th>{{__('messages.Actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sliders as $slider)
                            <tr>
                                <td><img src="{{Storage::url('uploads/'.$slider->image)}}" style="width: 150px;" /></td>

                                <td nowrap>
                                    <a href="{{route('slider.show', $slider->id)}}" class="btn btn-danger">{{__('messages.Delete')}}</a>
                                </td>
                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                </div>
            </div>

            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
    <div class="modal fade" id="m_modal_" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('messages.Add')}} {{__('messages.Slider')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{route('slider.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group m-form__group row">
                            <label class="col-lg-3 col-form-label">{{__('messages.Image')}}:</label>
                            <div class="col-lg-6">
                                <input type="file" class="form-control m-input dropify" name="image" />
                                @error('image')
                                <span class="m-form__help text-danger">{{$message}}</span>
                                @enderror
                            </div>
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


@endsection('content')
