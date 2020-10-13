@extends('pages.dashboard._layout')

@section('title', trans('pages/general.edit_profile'))
@section('mobile_dashboard', 'menu--active')
@section('side_dashboard', 'side-menu--active')

@section('style')
@endsection

@section('breadcrumb')
    <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
        <a href="{{ route('dashboard.dashboard') }}" class="">{{ trans('pages/general.home') }}</a>
        <i data-feather="chevron-right" class="breadcrumb__icon"></i>
        <a href="#" class="breadcrumb--active">{{ trans('pages/general.edit_profile') }}</a>
    </div>
@endsection

@section('content')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 lg:col-span-4 xxl:col-span-3 flex lg:block flex-col-reverse">
            <div class="intro-y box mt-5">
                <div class="relative flex items-center p-5">
                    <div class="w-12 h-12 image-fit">
                        <img alt="{{ $user->full_name }}" class="rounded-full"
                             src="{{ $user->image }}">
                    </div>
                    <div class="ml-4 mr-auto">
                        <div class="font-medium text-base">{{ $user->full_name }}</div>
                    </div>
                </div>
                <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                    <a class="flex items-center text-theme-1 dark:text-theme-10 font-medium" href="#"> <i
                            data-feather="activity" class="w-4 h-4 mr-2"></i>اطلاعات شخصی</a>
                </div>
            </div>
        </div>
        <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
            <div class="intro-y box lg:mt-5">
                <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">
                        {{ trans('pages/general.edit_profile') }}
                    </h2>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-12 gap-5">
                        <div class="col-span-12 xl:col-span-4">
                            <form method="post"
                                  action="{{ route('dashboard.profile.image.update') }}"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5">
                                    <div class="h-40 relative image-fit cursor-pointer zoom-in mx-auto">
                                        <img class="rounded-md" alt="{{ $user->full_name }}"
                                             src="{{ $user->image }}">
                                    </div>
                                    <div class="mx-auto cursor-pointer relative mt-5">
                                        <button type="button" class="button w-full bg-theme-1 text-white">
                                            تغییر تصویر
                                        </button>
                                        <input type="file" onchange="form.submit()" name="image"
                                               class="w-full h-full top-0 left-0 absolute opacity-0">
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="col-span-12 xl:col-span-8">
                            <form method="post" action="{{ route('dashboard.profile.update') }}">
                                @csrf
                                <div>
                                    <label for="first_name">{{ trans('validation.attributes.first_name') }}</label>
                                    <input type="text" id="first_name" name="first_name"
                                           class="input w-full border bg-gray-100 cursor-not-allowed mt-2"
                                           value="{{ $user->first_name }}">
                                </div>
                                <div class="mt-2">
                                    <label for="last_name">{{ trans('validation.attributes.last_name') }}</label>
                                    <input type="text" id="last_name" name="last_name"
                                           class="input w-full border bg-gray-100 cursor-not-allowed mt-2"
                                           value="{{ $user->last_name }}">
                                </div>
                                <div class="mt-2">
                                    <label for="email">{{ trans('validation.attributes.email') }}</label>
                                    <input type="text" id="email" name="email"
                                           class="input w-full border bg-gray-100 cursor-not-allowed mt-2"
                                           value="{{ $user->email }}">
                                </div>
                                @if(($tempEmail = $user->userEmailReset) != null)
                                    <div class="col-12">
                                        <div class="rounded-md flex items-center px-5 py-4 mb-2 bg-theme-6 text-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                 stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-alert-octagon w-6 h-6 mr-2">
                                                <polygon
                                                    points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
                                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                            </svg>

                                            {{ trans('pages/dashboard/profile.confirm_your_email') }}
                                            <a target="_blank"
                                               href="{{ str_replace('@', 'http://',strrchr($tempEmail->email, '@')) }}">
                                                ({{ $tempEmail->email }})
                                            </a>

                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                 stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-x w-4 h-4 ml-auto">
                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                <line x1="6" y1="6" x2="18" y2="18"></line>
                                            </svg>
                                        </div>
                                    </div>
                                @endif
                                <button type="submit" class="button w-20 bg-theme-1 text-white mt-3">ذخیره</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection

