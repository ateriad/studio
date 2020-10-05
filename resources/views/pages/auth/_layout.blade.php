<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="{{ asset('admin_assets/images/logo.svg') }}" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@lang('pages/general.app_name') | @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')
    <meta name="success" content="{{ session('success') }}">
    <meta name="error" content="{{ session('error') }}">
    <meta name="message" content="{{ session('message') }}">
    <meta name="author" content="info@ateriad.ir">
    <link rel="stylesheet" href="{{ asset('admin_assets/css/app.css') }}"/>
    <link rel="stylesheet" href="{{ m(asset('admin_assets/css/main.css')) }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/toastr/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ m(asset('vendor/toastr/custom.toastr.css')) }}">
    @yield('css')
</head>
<body class="login">
<div class="container sm:px-10">
    @yield('content')
</div>
<script src="{{ asset('admin_assets/js/app.js') }}"></script>
<script src="{{ m(asset('admin_assets/js/main.js')) }}"></script>

<script src="{{ asset('vendor/jquery-3.5.1/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
<script src="{{ m(asset('vendor/toastr/custom.toastr.js')) }}"></script>
@yield('js')
</body>
</html>
