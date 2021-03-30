@extends('pages.dashboard._layout')

@section('title', trans('pages/dashboard/users.users_edit'))

@section('mobile_users', 'menu--active')
@section('mobile_users_index', 'menu--active')
@section('mobile_users_sub', 'menu__sub-open')
@section('side_users', 'side-menu--active')
@section('side_users_index', 'side-menu--active')
@section('side_users_sub', 'side-menu__sub-open')

@section('style')
    <link rel="stylesheet" href="{{ asset('vendor/dropzone-5.7.0/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dropzone-5.7.0/min/basic.min.css') }}">
@endsection

@section('breadcrumb')
    <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
        <a href="{{ route('dashboard.index') }}" class="">{{ trans('pages/general.home') }}</a>
        <i data-feather="chevron-right" class="breadcrumb__icon"></i>
        <a href="#" class="breadcrumb--active">{{ trans('pages/dashboard/users.users_edit') }}</a>
    </div>
@endsection

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ $user->full_name }}
        </h2>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12">
            <div class="intro-y box">
                <div class="p-5">
                    <form action="{{ route('dashboard.users.update', ['user' => $user->id]) }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-12 gap-4 row-gap-5 mt-5">
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="first_name"
                                       class="d-block mb-2">{{ trans('validation.attributes.first_name') }}</label>
                                <input type="text"
                                       class="input w-full border flex-1 @error('first_name') border-theme-6 @enderror"
                                       id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}"
                                       placeholder="{{ trans('validation.attributes.first_name') }}">
                                @error('first_name')
                                <div class="text-theme-6 mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="last_name"
                                       class="d-block mb-2">{{ trans('validation.attributes.last_name') }}</label>
                                <input type="text"
                                       class="input w-full border flex-1 @error('last_name') border-theme-6 @enderror"
                                       id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}"
                                       placeholder="{{ trans('validation.attributes.last_name') }}">
                                @error('last_name')
                                <div class="text-theme-6 mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="email"
                                       class="d-block mb-2">{{ trans('validation.attributes.email') }}</label>
                                <input type="text"
                                       class="input w-full border flex-1 @error('email') border-theme-6 @enderror"
                                       id="email" name="email" value="{{ old('email', $user->email) }}"
                                       placeholder="{{ trans('validation.attributes.email') }}">
                                @error('email')
                                <div class="text-theme-6 mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="cellphone"
                                       class="d-block mb-2">{{ trans('validation.attributes.cellphone') }}</label>
                                <input type="text"
                                       class="input w-full border flex-1 @error('cellphone') border-theme-6 @enderror"
                                       id="cellphone" name="cellphone" value="{{ old('cellphone', $user->cellphone) }}"
                                       placeholder="{{ trans('validation.attributes.cellphone') }}">
                                @error('cellphone')
                                <div class="text-theme-6 mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="intro-y col-span-12">
                                <label for="image"
                                       class="d-block mb-2">{{ trans('validation.attributes.image') }}</label>
                                <label
                                    class="input w-full border d-block overflow-hidden @error('image') border-theme-6 @enderror">
                                    <span>{{ $user->image ?? trans('pages/general.select_a_file') }}</span>
                                    <input type="file" class="custom-file-input" accept="image/*"
                                           id="image" name="image"
                                           hidden>
                                </label>
                                @error('image')
                                <div class="text-theme-6 mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="intro-y col-span-12">
                                <button type="submit" class="button bg-theme-1 text-white mt-2">
                                    {{ trans('pages/general.save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection

