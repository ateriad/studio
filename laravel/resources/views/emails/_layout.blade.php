<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
    <title>@yield('title')</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0 "/>
    <style>
        body {
            margin: 0 !important;
            padding: 0 !important;
            -webkit-text-size-adjust: 100% !important;
            -ms-text-size-adjust: 100% !important;
            -webkit-font-smoothing: antialiased !important;
        }

        a {
            text-decoration: none;
        }

        .btn {
            display: inline-block;
            color: #727E8C;
            text-align: center;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-color: transparent;
            border: 0 solid transparent;
            padding: .467rem 1.5rem;
            font-size: 1rem;
            line-height: 1.6rem;
            border-radius: .267rem;
        }

        .btn-primary {
            color: #FFF;
            background-color: #5A8DEE;
            border-color: #5A8DEE;
        }

        .top_nav {
            background-color: #5a8dee;
            overflow: hidden;
            margin-bottom: 10px;
        }

        .top_nav a {
            float: right;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }

        .body-container {
            margin: 20px;
        }

    </style>
</head>
<body bgcolor="#efefef" dir="rtl">
<div class="top_nav" id="top_nav">
    <a href="{{ route('home') }}">
        <img src="{{ asset('dashboard_assets/images/logo.svg') }}"
             alt="{{ trans('pages/general.app_name') }}"
             width="25px">
    </a>
    <a href="#">
        {{ trans('pages/general.app_name') }}
    </a>
</div>
<div class="body-container">
    @yield('body')

    <hr style="margin: 20px 30px">
    <a href="{{ asset('/') }}">{{ trans('pages/general.app_name') }}</a>
</div>
</body>
