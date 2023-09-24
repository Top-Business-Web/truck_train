@extends('Admin.mainFrame')

@section('style')


@endsection

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">

        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title m-subheader__title--separator">اضافة سائق جديد</h3>
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
                                السائقون
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="{{route('drivers.index')}}" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
												<span>
													<i class="la la-back"></i>
													<span>عودة</span>
												</span>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item"></li>

                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">

                    <form class="m-form" method="post" action="{{route('drivers.store')}}" id="Form">
                        @csrf
                        <div class="m-portlet__body">
                            <div class="m-form__section m-form__section--first">

                                {{-------------------------------------------}}

                                <h3 class="row text-center mt-3 mb-3">المعلومات الرئيسية</h3>

                                <div class="form-group m-form__group row">
                                    <label class="col-lg-3 col-form-label">{{__('messages.Username')}}:</label>
                                    <div class="col-lg-6">
                                        <input required type="text" class="form-control m-input" placeholder="{{__('messages.Enter full name')}}" name="name">
                                    </div>
                                </div>

                                <input required type="hidden" value="+966" name="phone_code">

                                <div class="form-group m-form__group row">
                                    <label class="col-lg-3 col-form-label">{{__('messages.phone')}}:</label>
                                    <div class="col-lg-6">
                                        <input  required type="text" class="form-control m-input" name="phone" />
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <label class="col-lg-3 col-form-label">رقم الهوية الوطنية :</label>
                                    <div class="col-lg-6">
                                        <input required type="text" class="form-control m-input" placeholder="رقم الهوية الوطنية" name="national_id_num">
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <label class="col-lg-3 col-form-label">{{__('messages.Email')}}:</label>
                                    <div class="col-lg-6">
                                        <input required type="email" class="form-control m-input"  name="email">

                                    </div>
                                </div>



                                <div class="form-group m-form__group row">
                                    <label class="col-lg-3 col-form-label">{{__('messages.logo')}}:</label>
                                    <div class="col-lg-6">
                                        <input required type="file" class="form-control m-input dropify" name="logo" />
                                    </div>
                                </div>


                                {{-------------------------------------------}}
                                <h3 class="row text-center mt-3 mb-3"> العنوان</h3>
                                <input  required readonly  value="24.774265" class="form-control" type="hidden" name="latitude" id="lat" >
                                <input required readonly class="form-control" value="46.738586" type="hidden" name="longitude" id="long" >
                                <input required  class="form-control"   type="hidden" readonly value="الرياض" id="address" name="address">

                                <div class="form-group m-form__group row">
                                <div  id='map_canvas' style="width: 100%; height: 300px;"></div>
                                </div>
                                {{-------------------------------------------}}

                                <h3 class="row text-center mt-3 mb-3"> معلومات الخدمة</h3>

                                <div class="form-group m-form__group row">
                                    <label class="col-lg-3 col-form-label">اختر نوع الخدمة :</label>
                                    <div class="col-lg-6">
                                        <select required class="form-control" name="service_id" id="service_id">
                                            <option value="">اختر نوع الخدمة</option>
                                            @foreach($services as $service)
                                                <option value="{{$service->id}}">{{$service->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <label class="col-lg-3 col-form-label">رقم المركبة :</label>
                                    <div class="col-lg-6">
                                        <input required type="text" class="form-control m-input"  name="vehicle_id_num">

                                    </div>
                                </div>


                                <div class="form-group m-form__group row">
                                    <label class="col-lg-3 col-form-label">تاريخ انتهاء الإستمارة :</label>
                                    <div class="col-lg-6">
                                        <input required type="date" class="form-control m-input"  name="form_expiry_date">

                                    </div>
                                </div>


                                <div class="form-group m-form__group row">
                                    <label class="col-lg-3 col-form-label">تاريخ انتهاء التأمين :</label>
                                    <div class="col-lg-6">
                                        <input required type="date" class="form-control m-input"  name="insurance_expiry_date">

                                    </div>
                                </div>

                                {{-------------------------------------------}}

                                <h3 class="row text-center mt-3 mb-3">تابع معلومات الخدمة</h3>

                                <div class="form-group m-form__group row">
                                    <label class="col-lg-3 col-form-label">صورة الإقامة : </label>
                                    <div class="col-lg-6">
                                        <input required type="file" class="form-control m-input dropify" name="residency_photo" />
                                    </div>
                                </div>


                                <div class="form-group m-form__group row">
                                    <label class="col-lg-3 col-form-label">صورة الإستمارة :</label>
                                    <div class="col-lg-6">
                                        <input required type="file" class="form-control m-input dropify" name="form_photo" />
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <label class="col-lg-3 col-form-label">صورة التأمين :</label>
                                    <div class="col-lg-6">
                                        <input required type="file" class="form-control m-input dropify" name="insurance_photo" />
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <label class="col-lg-3 col-form-label">صورة المركبة</label>
                                    <div class="col-lg-6">
                                        <input required type="file" class="form-control m-input dropify" name="vehicle_image" />
                                    </div>
                                </div>



                            </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions">
                                <div class="row">
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-6">
                                        <button type="submit" id="submit" class="btn btn-success">{{__('messages.submit')}}</button>
                                        <button type="reset" class="btn btn-secondary">{{__('messages.Cancel')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAeyMUJgKAhnNXbILHONb1um72CNzELFRY&libraries=places"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#service_id").select2()
    </script>

    <script>
        $(document).on('submit','form#Form',function(e) {
            e.preventDefault();
            var myForm = $("#Form")[0]
            var formData = new FormData(myForm)
            var url = $('#Form').attr('action');
            $.ajax({
                url:url,
                type: 'POST',
                data: formData,
                beforeSend: function(){
                    $(':input[type="submit"]').prop('disabled', true);

                },
                complete: function(){


                },
                success: function (data) {
                   // console.log(data)
                    window.setTimeout(function() {
                        toastr.success('تمت العملية بنجاح','جيد', {"positionClass":"toast-top-right", "progressBar" : true})
                        location.replace('{{route('drivers.index')}}')
                        $(':input[type="submit"]').prop('disabled', true);

                    }, 2000);

                },
                error: function (data) {
                    $(':input[type="submit"]').prop('disabled', false);

                    if (data.status === 500) {
                        toastr.error('خطأ','خطأ', {"positionClass":"toast-top-right", "progressBar" : true})

                    }
                    if (data.status === 422) {
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors, function (key, value) {
                            if ($.isPlainObject(value)) {
                                $.each(value, function (key, value) {
                                    toastr.error(key,value, {"positionClass":"toast-top-right", "progressBar" : true})

                                });

                            } else {

                            }
                        });
                    }
                },//end error method

                cache: false,
                contentType: false,
                processData: false
            });
        });
    </script>

    <script>
        googleMap()
        function googleMap() {
            var lat = parseFloat(document.getElementById('lat').value)
            var long = parseFloat(document.getElementById('long').value)
            var map = new google.maps.Map(document.getElementById('map_canvas'), {
                zoom: 10,
                center: new google.maps.LatLng(lat,long),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var myMarker = new google.maps.Marker({
                position: new google.maps.LatLng(lat,long),
                draggable: true
            });

            google.maps.event.addListener(myMarker, 'dragend', function (evt) {
                document.getElementById('lat').value = evt.latLng.lat()
                document.getElementById('long').value = evt.latLng.lng()
                getReverseGeocodingData(evt.latLng.lat(),evt.latLng.lng())
            });

            map.setCenter(myMarker.position);
            myMarker.setMap(map);
        }

        function getReverseGeocodingData(lat, lng) {
            var latlng = new google.maps.LatLng(lat, lng);
            // This is making the Geocode request
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latlng },  (results, status) =>{
                // This is checking to see if the Geoeode Status is OK before proceeding
                if (status == google.maps.GeocoderStatus.OK) {
                    console.log(results);
                    document.getElementById("address").value = results[0].formatted_address;
                }
            });
            return '';
        }
    </script>


@endsection

