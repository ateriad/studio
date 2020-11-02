@extends('pages.auth._layout')

@section('title', trans('pages/general.sign_in'))

@section('content')
    <div class="block xl:grid grid-cols-2 gap-4">
        <div class="hidden xl:flex flex-col min-h-screen">
            <a href="#" class="-intro-x flex items-center pt-5">
                <img alt="{{ trans('pages/general.app_name') }}" class="w-6"
                     src="{{ asset('dashboard_assets/images/logo.svg') }}">
                <span class="text-white text-lg ml-3">{{ trans('pages/general.app_name') }}</span>
            </a>
            <div class="my-auto">
                <img alt="{{ trans('pages/general.app_name') }}" class="-intro-x w-1/2 -mt-16"
                     src="{{ asset('dashboard_assets/images/illustration.svg') }}">
                <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                    {{ trans('pages/general.sign_in') }}
                </div>
            </div>
        </div>
        <!-- END: Login Info -->
        <!-- BEGIN: Login Form -->
        <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
            <div
                class="my-auto mx-auto xl:ml-20 bg-white xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                    {{ trans('pages/general.sign_in') }}
                </h2>
                <div class="intro-x mt-2 text-gray-500 xl:hidden text-center">
                    {{ trans('pages/general.sign_in') }}
                </div>
                <div class="intro-x mt-8">
                    <form method="post" action="{{ route('auth.sign-in') }}">
                        @csrf
                        <div class="intro-x mt-2">
                            <input id="cellphone" name="cellphone" type="text"
                                   class="intro-x login__input input input--lg border border-gray-300 block @error('cellphone') border-theme-6 @enderror"
                                   title=""
                                   placeholder="{{ trans('validation.attributes.cellphone') }}"
                                   required>
                            @error('cellphone')
                            <div class="text-theme-6 mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="intro-x mt-2">
                            <input id="password" name="password" type="password"
                                   class="intro-x login__input input input--lg border border-gray-300 block @error('password') border-theme-6 @enderror"
                                   title=""
                                   placeholder="{{ trans('validation.attributes.password') }}"
                                   required>
                            @error('password')
                            <div class="text-theme-6 mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                            <button id="request"
                                    class="button button--lg w-full xl:w-32 text-white bg-theme-1 xl:mr-3">
                                {{ trans('pages/general.sign_in') }}
                            </button>
                        </div>
                    </form>
                </div>

                <div class="intro-x mt-10 xl:mt-24 text-gray-700 dark:text-gray-600 text-center xl:text-left">
                    با ورود شما تمامی شرایط زیر را میپذیرید
                    <br>
                    <a class="text-theme-1 dark:text-theme-10" href="#">قوانین و مقررات</a> و <a
                        class="text-theme-1 dark:text-theme-10" href="#">حریم شخصی</a>
                </div>
            </div>
        </div>
        <!-- END: Login Form -->
    </div>
@endsection
