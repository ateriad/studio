@extends('pages.dashboard._layout')

@section('title', trans('pages/dashboard/assets.asset_categories_create'))

@section('mobile_asset_categories', 'menu--active')
@section('mobile_asset_categories_create', 'menu--active')
@section('mobile_asset_categories_sub', 'menu__sub-open')
@section('side_asset_categories', 'side-menu--active')
@section('side_asset_categories_create', 'side-menu--active')
@section('side_asset_categories_sub', 'side-menu__sub-open')

@section('style')
    <link rel="stylesheet" href="{{ asset('vendor/dropzone-5.7.0/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dropzone-5.7.0/min/basic.min.css') }}">
@endsection

@section('breadcrumb')
    <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
        <a href="{{ route('dashboard.index') }}" class="">{{ trans('pages/general.home') }}</a>
        <i data-feather="chevron-right" class="breadcrumb__icon"></i>
        <a href="#" class="breadcrumb--active">{{ trans('pages/dashboard/assets.asset_categories_create') }}</a>
    </div>
@endsection

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ trans('pages/dashboard/assets.asset_categories_create') }}
        </h2>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12">
            <div class="intro-y box">
                <div class="p-5">
                    <form action="{{ route('dashboard.asset-categories.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="image" id="image" value="" required>
                        <div class="grid grid-cols-12 gap-4 row-gap-5 mt-5">
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="name" class="d-block mb-2">{{ trans('validation.attributes.name') }}</label>
                                <input type="text"
                                       class="input w-full border flex-1 @error('name') border-theme-6 @enderror"
                                       id="name" name="name"
                                       placeholder="{{ trans('validation.attributes.name') }}">
                                @error('name')
                                <div class="text-theme-6 mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="parent"
                                       class="d-block mb-2">{{ trans('validation.attributes.parent') }}</label>
                                <select class="input w-full border flex-1 @error('parent') border-theme-6 @enderror"
                                        id="parent" name="parent">
                                    <option value="">{{ trans('pages/general.without_parent') }}</option>
                                    @foreach($parents as $parent)
                                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                    @endforeach
                                </select>
                                @error('parent')
                                <div class="text-theme-6 mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="intro-y col-span-12">
                                <label for="image"
                                       class="d-block mb-2">{{ trans('validation.attributes.image') }}</label>
                                <div id="dropzone"
                                     class="needsclick border-gray-200 border-dashed dz-clickable .border-gray-200"
                                     data-action="{{ route('upload.temp') }}">
                                    <div class="dz-message">
                                        <div><i class="fas fa-plus"></i></div>
                                        <div>{{ trans('pages/general.click_to_upload_image') }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="intro-y col-span-12">
                                <label for="info" class="d-block mb-2">{{ trans('validation.attributes.info') }}</label>
                                <textarea class="input w-full border mt-2 @error('info') border-theme-6 @enderror"
                                          placeholder=""
                                          id="info" name="info"></textarea>
                                @error('info')
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
    <script type="text/javascript" src="{{ asset('vendor/dropzone-5.7.0/min/dropzone.min.js') }}"></script>
    <script>
        let image = '';
        let myDropzone = new Dropzone("#dropzone", {
            url: $('#dropzone').data('action'),
            method: 'post',
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            },
            paramName: "file",
            maxFiles: 1,
            acceptedFiles: 'image/*',
            dictInvalidFileType: 'فایل قابل قبول نمیباشد.',
            thumbnailMethod: 'contain',
            addRemoveLinks: true,
            dictRemoveFile: '✘',
            init: function () {
                this.on("removedfile", function (file) {
                    $('#image').val('');
                });

                this.on("success", function (file, responseText) {
                    $('#image').val(responseText.path);
                });

                this.on("maxfilesexceeded", function (file) {
                    this.removeAllFiles();
                    this.addFile(file);
                });
            }
        });
    </script>
@endsection

