@extends('pages.admin._layout')

@section('title', trans('pages/admin/assets.assets_create'))

@section('mobile_assets', 'menu--active')
@section('mobile_assets_index', 'menu--active')
@section('mobile_assets_sub', 'menu__sub-open')
@section('side_assets', 'side-menu--active')
@section('side_assets_index', 'side-menu--active')
@section('side_assets_sub', 'side-menu__sub-open')

@section('style')
    <link rel="stylesheet" href="{{ asset('vendor/dropzone-5.7.0/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dropzone-5.7.0/min/basic.min.css') }}">
@endsection

@section('breadcrumb')
    <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
        <a href="{{ route('admin.dashboard') }}" class="">{{ trans('pages/general.home') }}</a>
        <i data-feather="chevron-right" class="breadcrumb__icon"></i>
        <a href="#" class="breadcrumb--active">{{ trans('pages/admin/assets.assets_create') }}</a>
    </div>
@endsection

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ $asset->name }}
        </h2>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12">
            <div class="intro-y box">
                <div class="p-5">
                    <form action="{{ route('admin.assets.update', ['asset' => $asset->id]) }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-12 gap-4 row-gap-5 mt-5">
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="name" class="d-block mb-2">{{ trans('validation.attributes.name') }}</label>
                                <input type="text"
                                       class="input w-full border flex-1 @error('name') border-theme-6 @enderror"
                                       id="name" name="name" value="{{ $asset->name }}"
                                       placeholder="{{ trans('validation.attributes.name') }}">
                                @error('name')
                                <div class="text-theme-6 mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="intro-y col-span-12 sm:col-span-6">
                                <label for="categories" class="d-block mb-2">
                                    {{ trans('validation.attributes.categories') }}
                                </label>
                                <select
                                    class="input w-full border flex-1 select2 @error('categories') invalid border-theme-6 @enderror"
                                    id="categories" name="categories[]" multiple>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ in_array($category->id, $asset->categories()->pluck('category_id')->toArray()) ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categories')
                                <div class="text-theme-6 mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="intro-y col-span-12">
                                <label for="thumbnail"
                                       class="d-block mb-2">{{ trans('validation.attributes.thumbnail') }}</label>
                                <label
                                    class="input w-full border d-block overflow-hidden @error('thumbnail') border-theme-6 @enderror">
                                    <span>{{ $asset->thumbnail ?? trans('pages/general.select_a_file') }}</span>
                                    <input type="file" class="custom-file-input" accept="image/*"
                                           id="thumbnail" name="thumbnail" value="{{ old('thumbnail') }}"
                                           hidden>
                                </label>
                                @error('thumbnail')
                                <div class="text-theme-6 mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="intro-y col-span-12">
                                <label for="file" class="d-block mb-2">
                                    {{ trans('validation.attributes.file') }}
                                </label>
                                <input type="hidden" name="file" id="file" value="" required>
                                @error('file')
                                <div class="text-theme-6 mt-2 mb-2">{{ $message }}</div>
                                @enderror
                                <div id="dropzone"
                                     class="needsclick border-gray-200 border-dashed dz-clickable .border-gray-200"
                                     data-action="{{ route('upload.temp') }}">
                                    <div class="dz-message">
                                        <div><i class="fas fa-plus"></i></div>
                                        <div>{{ trans('pages/general.click_to_upload_file') }}</div>
                                    </div>
                                </div>
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
        let images = [@json($asset->path_url)];
    </script>
    <script>
        let file = '';
        let myDropzone = new Dropzone("#dropzone", {
            url: $('#dropzone').data('action'),
            method: 'post',
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            },
            paramName: "file",
            maxFiles: 1,
            dictInvalidFileType: 'فایل قابل قبول نمیباشد.',
            thumbnailMethod: 'contain',
            addRemoveLinks: true,
            dictRemoveFile: '✘',
            init: function () {
                this.on('addedfile', function (file) {
                    if (this.files[1] != null) {
                        this.removeFile(this.files[0]);
                    }

                    let ext = file.name.split('.').pop();

                    if (ext === "blend") {
                        $(file.previewElement).find(".dz-image img").attr("src", window.location.origin + "/admin_assets/images/extensions/blend.png");
                    }
                });

                this.on("removedfile", function (file) {
                    $('#file').val('');
                });

                this.on("success", function (file, responseText) {
                    $('#file').val(responseText.path);
                });

                this.on("maxfilesexceeded", function (file) {
                    this.removeAllFiles();
                    this.addFile(file);
                });
            }
        });

        let mockFile = [];

        $.each(images, function (i, image) {
            mockFile[i] = {name: image, size: 12345};
            let ext = image.split('.').pop();

            myDropzone.options.addedfile.call(myDropzone, mockFile[i]);
            myDropzone.files.push(mockFile[i]);

            if (ext === 'blend') {
                myDropzone.options.thumbnail.call(myDropzone, mockFile[i], window.location.origin + "/admin_assets/images/extensions/blend.png");
            } else {
                myDropzone.options.thumbnail.call(myDropzone, mockFile[i], image);
            }
            myDropzone.emit("complete", mockFile[i]);
        });
    </script>
@endsection

