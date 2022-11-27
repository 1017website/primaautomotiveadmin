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
        <link rel="icon" type="image/png" sizes="16x16" href="{{asset('plugins/images/favicon.png')}}">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
        @livewireStyles
        <!-- Scripts -->
        <script src="{{asset('js/app.js') }}" defer></script>
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
        <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
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
                            <label for="cust_name" class="col-sm-2 text-left control-label col-form-label">{{ __('Choose Your Color') }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="cust_name" name="cust_name" value="" required="true">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="cust_name" class="col-sm-2 text-left control-label col-form-label">{{ __('Choose Your Service') }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="cust_name" name="cust_name" value="" required="true">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cust_name" class="col-sm-2 text-left control-label col-form-label">{{ __('Choose Your Vehicle') }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="cust_name" name="cust_name" value="" required="true">
                            </div>
                        </div>     

                        <div class="form-group row">
                            <div class="col-sm-12 text-center">
                                <a href="#" type="button" class="btn btn-default">Go</a>
                            </div>
                        </div>  

                        <div class="border-top" style="margin-bottom: 1rem;"></div>

                        <div class="cars">
                            <h4 class="text-center" style="margin-bottom: 1.5rem;">Car</h4>



                        </div>

                    </div>

                </div>

                <footer class="footer text-center ml-auto mr-auto" style="position:absolute;bottom: 0;">
                    All Rights Reserved by <a href="#" target="_blank"><strong>{{ config('app.name') }}</strong></a>. Designed and Developed by <a target="_blank" href="https://1017studio.com"><strong>1017Studio</strong></a>.
                </footer>
            </div>


        </div>

        @stack('modals')        

        <script>
$('[data-toggle="tooltip"]').tooltip();
$(".preloader").fadeOut();
$(".select2").select2();
$('.mydatepicker').datepicker({
    autoclose: true,
    format: 'dd-mm-yyyy'
});
(function ($) {
    $.fn.inputFilter = function (inputFilter) {
        return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function () {
            if (inputFilter(this.value)) {
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            } else {
                this.value = "";
            }
        });
    };
}(jQuery));
$(document).ready(function () {
    $(".phone").inputFilter(function (value) {
        return /^\d*$/.test(value);    // Allow digits only, using a RegExp
    });
});
        </script>
    </body>
</html>
