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
        <link href="{{asset('plugins/libs/datatables.net-bs4/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
        <link href="{{asset('plugins/libs/select2/dist/css/select2.min.css')}}" rel="stylesheet">
        <link href="{{asset('plugins/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
        <link href="{{asset('plugins/libs/notification/notifications.css')}}" rel="stylesheet">
        <link rel="icon" type="image/png" sizes="16x16" href="{{asset('plugins/images/favicon.png')}}">
        @livewireStyles
        <!-- Scripts -->
        <script src="{{asset('js/app.js') }}" defer></script>
        <script src="{{asset('plugins/libs/jquery/dist/jquery.min.js')}}"></script>
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
            <!-- Navbar & Sidebar -->
            @livewire('navigation-menu')

            <!-- Page Content -->
            <div class="page-wrapper">
                {{ $slot }}
                <footer class="footer text-center">
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
            (function($) {
                $.fn.inputFilter = function(inputFilter) {
                  return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
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
            $(document).ready(function() {
                $(".phone").inputFilter(function(value) {
                  return /^\d*$/.test(value);    // Allow digits only, using a RegExp
                });
            });
        </script>
    </body>
</html>
