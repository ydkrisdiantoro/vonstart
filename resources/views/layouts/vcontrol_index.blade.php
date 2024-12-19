<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            @yield('title')
            {{ ' - '.config('vcontrol.app_name') }}
        </title>

        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-icons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/vonstemp.css') }}">

        <style>
            .svg-container{
                background-image: url('{{ asset('assets/img/circuit.svg') }}');
                background-repeat: repeat;
                opacity: .02;
            }
        </style>

        @yield('extra-css')
    </head>

    <body>
        <div class="svg-container"></div>

        @yield('body')

        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/vonstemp.js') }}"></script>

        @yield('extra-js')

    </body>

</html>
