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
    @yield('style')
</head>

<body class="app">
<!-- BEGIN: Mobile Menu -->
<div class="mobile-menu md:hidden">
    <div class="mobile-menu-bar">
        <a href="#" class="flex mr-auto">
            <img alt="Midone Tailwind HTML Admin Template" class="w-6"
                 src="{{ asset('admin_assets/images/logo.svg') }}">
        </a>
        <a href="javascript:void(0)" id="mobile-menu-toggler">
            <i data-feather="bar-chart-2"
               class="w-8 h-8 text-white transform -rotate-90"></i>
        </a>
    </div>
    @include('pages.admin._mobile_menu')
</div>
<!-- END: Mobile Menu -->
<div class="flex">
    <!-- BEGIN: Side Menu -->
    <nav class="side-nav">
        <a href="#" class="intro-x flex items-center pl-5 pt-4">
            <img alt="Midone Tailwind HTML Admin Template" class="w-6"
                 src="{{ asset('admin_assets/images/logo.svg') }}">
            <span class="hidden xl:block text-white text-lg ml-3">
                {{ trans('pages/general.app_name') }}
            </span>
        </a>
        <div class="side-nav__devider my-6"></div>
        @include('pages.admin._side_menu')
    </nav>
    <!-- END: Side Menu -->

    <!-- BEGIN: Content -->
    <div class="content">
        <!-- BEGIN: Top Bar -->
        <div class="top-bar">

            @yield('breadcrumb')
            <span></span>

            <!-- BEGIN: Search -->
            <div class="intro-x relative mr-3 sm:mr-6">
                <div class="search hidden sm:block">
                    <input type="text" class="search__input input placeholder-theme-13" placeholder="جستجو...">
                    <i data-feather="search" class="search__icon dark:text-gray-300"></i>
                </div>
                <a class="notification sm:hidden" href="#">
                    <i data-feather="search" class="notification__icon dark:text-gray-300"></i>
                </a>
            </div>
            <!-- END: Search -->
            <!-- BEGIN: Notifications -->
            <div class="intro-x dropdown relative mr-auto sm:mr-6">
                <div class="dropdown-toggle notification notification--bullet cursor-pointer">
                    <i data-feather="bell"
                       class="notification__icon dark:text-gray-300">
                    </i>
                </div>
                <div
                    class="notification-content dropdown-box mt-8 absolute top-0 left-0 sm:left-auto sm:right-0 z-20 -ml-10 sm:ml-0">
                    <div class="notification-content__box dropdown-box__content box dark:bg-dark-6">
                        <div class="notification-content__title"> اطلاعیه ها</div>
                        <div class="cursor-pointer relative flex items-center ">
                            <div class="w-12 h-12 flex-none image-fit mr-1">
                                <img alt="Midone Tailwind HTML Admin Template" class="rounded-full"
                                     src="{{ auth()->user()->image }}">
                                <div
                                    class="w-3 h-3 bg-theme-9 absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                            </div>
                            <div class="ml-2 overflow-hidden">
                                <div class="flex items-center">
                                    <a href="javascript:void(0)" class="font-medium truncate mr-5">لئونارد دیکاپریو</a>
                                    <div class="text-xs text-gray-500 ml-auto whitespace-no-wrap">01:10بعد از ظهر</div>
                                </div>
                                <div class="w-full truncate text-gray-600">
                                    خوش آمدید
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Notifications -->
            <!-- BEGIN: Account Menu -->
            <div class="intro-x dropdown w-8 h-8 relative">
                <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in">
                    <img alt="Tailwind HTML Admin Template"
                         src="{{ auth()->user()->image }}">
                </div>
                <div class="dropdown-box mt-10 absolute w-56 top-0 right-0 z-20">
                    <div class="dropdown-box__content box bg-theme-38 dark:bg-dark-6 text-white">
                        <div class="p-4 border-b border-theme-40 dark:border-dark-3">
                            <div class="font-medium">
                                {{ auth()->user()->full_name }}
                            </div>
                        </div>
                        <div class="p-2">
                            <a href="#"
                               class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md">
                                <i data-feather="user" class="w-4 h-4 mr-2"></i>
                                {{ trans('pages/general.edit_profile') }}
                            </a>
                        </div>
                        <div class="p-2 border-t border-theme-40 dark:border-dark-3">
                            <a href="{{ route('auth.sign-out') }}"
                               class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md">
                                <i data-feather="toggle-right" class="w-4 h-4 mr-2"></i>
                                {{ trans('pages/general.sign_out') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Account Menu -->
        </div>
        <!-- END: Top Bar -->

        @yield('content')

    </div>
    <!-- END: Content -->
</div>

<script src="{{ asset('admin_assets/js/app.js') }}"></script>
<script src="{{ m(asset('admin_assets/js/main.js')) }}"></script>

<script src="{{ asset('vendor/jquery-3.5.1/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
<script src="{{ m(asset('vendor/toastr/custom.toastr.js')) }}"></script>
@yield('js')
</body>
</html>
