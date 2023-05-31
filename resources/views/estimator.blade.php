<!DOCTYPE html>
<html dir="ltr" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }}</title>
        <!-- Styles -->
        <link href="{{asset('css/app.css') }}" rel="stylesheet" >
        <link href="{{asset('plugins/libs/flot/css/float-chart.css')}}" rel="stylesheet">
        <link href="{{asset('css/style.min.css')}}" rel="stylesheet">
        <link href="{{asset('css/custom.css')}}" rel="stylesheet">
        <link href="{{asset('css/toastr.min.css')}}" rel="stylesheet">
        <link href="{{asset('plugins/libs/datatables.net-bs4/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
        <link href="{{asset('plugins/libs/select2/dist/css/select2.min.css')}}" rel="stylesheet">
        <link href="{{asset('plugins/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
        <link href="{{asset('plugins/libs/notification/notifications.css')}}" rel="stylesheet">
        <link href="{{asset('plugins/libs/magnific-popup/dist/magnific-popup.css')}}" rel="stylesheet">
        <link rel="icon" type="image/png" sizes="16x16" href="{{asset('plugins/images/favicon.png')}}">    

        @livewireStyles
        <!-- Scripts -->

        <script src="{{asset('plugins/libs/jquery/dist/jquery.min.js')}}"></script>
        <script src="{{asset('js/jquery-ui.js')}}"></script>
        <script src="{{asset('plugins/libs/popper.js/dist/umd/popper.min.js')}}"></script>
        <script src="{{asset('plugins/libs/bootstrap/dist/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('plugins/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js')}}"></script>
        <script src="{{asset('plugins/extra-libs/sparkline/sparkline.js')}}"></script>
        <script src="{{asset('js/waves.js')}}"></script>
        <script src="{{asset('js/sidebarmenu.js')}}"></script>
        <script src="{{asset('plugins/libs/flot/excanvas.js')}}"></script>
        <script src="{{asset('plugins/libs/flot/jquery.flot.js')}}"></script>
        <script src="{{asset('plugins/libs/flot/jquery.flot.pie.js')}}"></script>
        <script src="{{asset('plugins/libs/flot/jquery.flot.time.js')}}"></script>
        <script src="{{asset('plugins/libs/flot/jquery.flot.stack.js')}}"></script>
        <script src="{{asset('plugins/libs/flot/jquery.flot.crosshair.js')}}"></script>
        <script src="{{asset('plugins/libs/flot.tooltip/js/jquery.flot.tooltip.min.js')}}"></script>
        <script src="{{asset('js/pages/chart/chart-page-init.js')}}"></script>
        <script src="{{asset('plugins/extra-libs/DataTables/datatables.min.js')}}"></script>
        <script src="{{asset('plugins/libs/select2/dist/js/select2.full.min.js')}}"></script>
        <script src="{{asset('plugins/libs/select2/dist/js/select2.min.js')}}"></script>
        <script src="{{asset('plugins/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
        <script src="{{asset('plugins/libs/notification/notifications.js')}}"></script>
        <script src="{{asset('js/custom.min.js')}}"></script>
        <script src="{{asset('js/toastr.min.js')}}"></script>

        @livewireScripts       
    </head>
    <body>
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>

        <div id="main-wrapper">

            <nav class="navbar navbar-light bg-light" style="margin-bottom: 1rem;">
                <div class="container">
                    <span class="navbar-brand mb-0 h1">
                        <img src="{{asset('plugins/images/logo-color.PNG')}}" alt="logo" class="light-logo img-fluid" style="margin-left: auto;margin-right: auto;max-width: 10rem;"/>
                    </span>
                </div>
            </nav>

            <div class="container">
                <div class="row">
                    <div class="col-sm-12">

                        <h4 class="text-center" style="margin-bottom: 1.5rem;">Estimator</h4>

                        <div class="form-group row">
                            <label for="color_id" class="col-sm-2 text-left control-label col-form-label">{{ __('Choose Your Color') }}</label>
                            <div class="col-sm-10">
                                <select class="select2 form-control custom-select" id="color_id" name="color_id" style="width: 100%;">
                                    <option></option>
                                    @foreach($colors as $row)                                
                                    <option value="{{$row->id}}">{{$row->name}}</option>    
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="color" class="col-sm-2 text-left control-label col-form-label">{{ __('') }}</label>
                            <div class="col-sm-10">
                                <select class="select2 form-control custom-select" id="color" name="color" style="width: 100%;">
                                    <option></option>
                                    @foreach($colorPrimers as $row)                                
                                    <option value="{{$row->id}}">{{$row->name}}</option>    
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="type_service_id" class="col-sm-2 text-left control-label col-form-label">{{ __('Choose Your Service') }}</label>
                            <div class="col-sm-10">
                                <select class="select2 form-control custom-select" id="type_service_id" name="type_service_id" style="width: 100%;">
                                    <option></option>
                                    @foreach($services as $row)                                
                                    <option value="{{$row->id}}">{{$row->name}}</option>    
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="car_id" class="col-sm-2 text-left control-label col-form-label">{{ __('Choose Your Car') }}</label>
                            <div class="col-sm-10">
                                <select class="select2 form-control custom-select" id="car_id" name="car_id" style="width: 100%;">
                                    <option></option>
                                    @foreach($cars as $row)                                
                                    <option value="{{$row->id}}">{{$row->name}} {{$row->year}}</option>    
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12 text-center">
                                <a href="#" type="button" class="btn btn-default" id="btn-estimator">Go</a>
                            </div>
                        </div>  

                        <div class="border-top" style="margin-bottom: 1rem;"></div>

                        <div class="cars">

                        </div>

                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-12">
                        {{ __('Disclaimer') }}
                        <div class="col-sm-12">
                            <i>{{ isset($setting) ? $setting->disclaimer : '' }}</i>
                        </div>
                    </div>
                </div>
                <footer class="footer text-center ml-auto mr-auto">
                    All Rights Reserved by <a href="#" target="_blank"><strong>{{ config('app.name') }}</strong></a>. Designed and Developed by <a target="_blank" href="https://1017studio.com"><strong>1017Studio</strong></a>.
                </footer>
            </div>


        </div>

        @stack('modals')        

        <script>
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#color_id').select2({
        placeholder: "Please select a color"
    });
    $('#color').select2({
        placeholder: "Please select a color"
    });
    $('#type_service_id').select2({
        placeholder: "Please select a service"
    });
    $('#car_id').select2({
        placeholder: "Please select a car"
    });

    $('#color_id').on('change', function () {
        $.ajax({
            url: "{{ route('changeColor') }}",
            type: 'POST',
            dataType: 'json',
            data: {
                'color_id': this.value
            },
            success: function (res) {
                if (res.success) {
                    var $select = $("#type_service_id");
                    $select.empty().trigger("change");
                    var items = res.services;
                    var data = [];
                    $(items).each(function () {
                        if (!$select.find("option[value='" + this.id + "']").length) {
                            $select.append(new Option(this.text, this.id, true, true));
                        }
                        data.push(this.id);
                    });
                    $select.val(data).trigger('change');
                    $select.prepend('<option selected=""></option>').select2({placeholder: "Please select a service"});
                } else {
                    popup(res.message, 'error');
                }
            }
        });
    });

    $('#btn-estimator').on('click', function () {
        if ($("#color_id").val() == '') {
            popup('Color must be selected', 'error');
            return false;
        }

        if ($("#type_service_id").val() == '') {
            popup('Service must be selected', 'error');
            return false;
        }

        if ($("#car_id").val() == '') {
            popup('Car must be selected', 'error');
            return false;
        }

        $.ajax({
            url: "{{ route('showEstimator') }}",
            type: 'POST',
            dataType: 'html',
            data: {
                'color_id': $("#color_id").val(),
                'type_service_id': $("#type_service_id").val(),
                'car_id': $("#car_id").val()
            },
            success: function (res) {
                $('.cars').html(res);
            }
        });
    });
});

        </script>
    </body>
</html>
