<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" href="{{ asset('assets/img/icon.ico') }}" type="image/x-icon"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('assets/css/gijgo.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
        custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"], urls: ['assets/css/fonts.css']},
        active: function() {
            sessionStorage.fonts = true;
        }
        });
        
    </script>

    <!-- Fonts 
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    -->
    
</head>
<body>
    @yield('content')
    <script src="{{ asset('js/all.js') }}"></script>
    
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
