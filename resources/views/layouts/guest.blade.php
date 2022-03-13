<!DOCTYPE html>
<html dir="ltr" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }}</title>

        <link rel="icon" type="image/png" sizes="16x16" href="{{asset('plugins/images/favicon.png')}}">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link href="{{asset('css/style.min.css')}}" rel="stylesheet">
    </head>
    <body>
        <div class="main-wrapper">
            <div class="preloader">
                <div class="lds-ripple">
                    <div class="lds-pos"></div>
                    <div class="lds-pos"></div>
                </div>
            </div>

            <div class="auth-wrapper d-flex no-block justify-content-center align-items-center bg-dark">
                <div class="auth-box bg-dark border-top border-secondary">
                    {{ $slot }}
                </div>
            </div>
        </div>

        <script src="{{asset('js/app.js') }}" defer></script>
        <script src="{{asset('plugins/libs/jquery/dist/jquery.min.js')}}"></script>
        <script src="{{asset('plugins/libs/popper.js/dist/umd/popper.min.js')}}"></script>
        <script src="{{asset('plugins/libs/bootstrap/dist/js/bootstrap.min.js')}}"></script>
        <script>
            $('[data-toggle="tooltip"]').tooltip();
            $(".preloader").fadeOut();
        </script>
    </body>
</html>
