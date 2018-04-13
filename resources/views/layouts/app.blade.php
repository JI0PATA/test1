@include('layouts.menu')

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Template</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/validate.js') }}"></script>
    <script src="{{ asset('js/FormConfirm.js') }}"></script>

    <script src="{{ asset('js/jqueryui/jquery-ui.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('js/jqueryui/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('js/jqueryui/jquery-ui.structure.css') }}">
    <link rel="stylesheet" href="{{ asset('js/jqueryui/jquery-ui.theme.css') }}">
</head>
<body>
    @yield('menu')

    @yield('content')

    <script src="{{ asset('js/bootstrap.js') }}"></script>
</body>
</html>
