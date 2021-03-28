@extends('pages.dashboard._layout')

@section('title', trans('pages/dashboard/admins.admins_create'))

@section('mobile_admins', 'menu--active')
@section('mobile_admins_index', 'menu--active')
@section('mobile_admins_sub', 'menu__sub-open')
@section('side_admins', 'side-menu--active')
@section('side_admins_index', 'side-menu--active')
@section('side_assets_sub', 'side-menu__sub-open')

@section('style')
    <link rel="stylesheet" href="{{ asset('vendor/dropzone-5.7.0/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dropzone-5.7.0/min/basic.min.css') }}">
@endsection

@section('breadcrumb')
    <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
        <a href="{{ route('dashboard.index') }}" class="">{{ trans('pages/general.home') }}</a>
        <i data-feather="chevron-right" class="breadcrumb__icon"></i>
        <a href="#" class="breadcrumb--active">{{ trans('pages/dashboard/admins.admins_create') }}</a>
    </div>
@endsection

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ $admin->name }}
        </h2>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12">
            <div class="intro-y box">
                <div class="p-5">
                    <form action="{{ route('dashboard.admins.update', ['admin' => $admin->id]) }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-12 gap-4 row-gap-5 mt-5">
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="first_name" class="d-block mb-2">{{ trans('validation.attributes.first_name') }}</label>
                                <input type="text"
                                       class="input w-full border flex-1 @error('first_name') border-theme-6 @enderror"
                                       id="first_name" name="first_name" value="{{ $admin->first_name }}"
                                       placeholder="{{ trans('validation.attributes.first_name') }}">
                                @error('first_name')
                                <div class="text-theme-6 mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="last_name" class="d-block mb-2">{{ trans('validation.attributes.last_name') }}</label>
                                <input type="text"
                                       class="input w-full border flex-1 @error('last_name') border-theme-6 @enderror"
                                       id="last_name" name="last_name" value="{{ $admin->last_name }}"
                                       placeholder="{{ trans('validation.attributes.last_name') }}">
                                @error('last_name')
                                <div class="text-theme-6 mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="email" class="d-block mb-2">{{ trans('validation.attributes.email') }}</label>
                                <input type="text"
                                       class="input w-full border flex-1 @error('email') border-theme-6 @enderror"
                                       id="email" name="email" value="{{ $admin->email }}"
                                       placeholder="{{ trans('validation.attributes.email') }}">
                                @error('email')
                                <div class="text-theme-6 mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="cellphone" class="d-block mb-2">{{ trans('validation.attributes.cellphone') }}</label>
                                <input type="text"
                                       class="input w-full border flex-1 @error('cellphone') border-theme-6 @enderror"
                                       id="cellphone" name="cellphone" value="{{ $admin->cellphone }}"
                                       placeholder="{{ trans('validation.attributes.cellphone') }}">
                                @error('cellphone')
                                <div class="text-theme-6 mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="categories" class="d-block mb-2">
                                    {{ trans('validation.attributes.roles') }}
                                </label>
                                <select
                                    class="input w-full border flex-1 select2 @error('roles') invalid border-theme-6 @enderror"
                                    id="roles" name="roles[]" multiple>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ $admin->hasRole($role->id) ? 'selected' : '' }}>
                                            {{ $role->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('roles')
                                <div class="text-theme-6 mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="intro-y col-span-12">
                                <label for="image"
                                       class="d-block mb-2">{{ trans('validation.attributes.image') }}</label>
                                <label
                                    class="input w-full border d-block overflow-hidden @error('image') border-theme-6 @enderror">
                                    <span>{{ $admin->image ?? trans('pages/general.select_a_file') }}</span>
                                    <input type="file" class="custom-file-input" accept="image/*"
                                           id="image" name="image" value="{{ old('image') }}"
                                           hidden>
                                </label>
                                @error('thumbnail')
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

