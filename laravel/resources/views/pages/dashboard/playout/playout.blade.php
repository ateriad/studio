@extends('pages.dashboard._layout')

@section('title', trans('pages/general.dashboard'))
@section('mobile_studio', 'menu--active')
@section('side_studio', 'side-menu--active')

@section('style')
    <link rel="stylesheet" href="{{ asset('vendor/ion.rangeSlider/css/ion.rangeSlider.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dropzone-5.7.0/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dropzone-5.7.0/min/basic.min.css') }}">
    <style>
        #studio canvas {
            display: block;
        }

        #dropzone .dz-preview {
            margin: 2px;
        }
    </style>
@endsection

@section('breadcrumb')
    <div class="grid grid-cols-12 gap-6">
        <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
            <a href="{{ route('dashboard.index') }}" class="">{{ trans('pages/general.home') }}</a>
            <i data-feather="chevron-right" class="breadcrumb__icon"></i>
            <a href="#" class="breadcrumb--active">{{ trans('pages/general.studio') }}</a>
        </div>
    </div>
@endsection

@section('content')
    <div class="intro-y items-center mt-8 mb-5">
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
                <div class="intro-y">
                    <div id="studio">
                        <div id='canvas-container'></div>
                    </div>
                    <div id="toolbox" class="mt-2">
                        <div>
                            <button id="start_stream"
                                    class="button w-24 mr-1 mb-2 bg-theme-6 text-white"
                                    disabled>
                                ضبط کردن
                            </button>
                            <button id="stop_stream" style="display: none"
                                    class="button w-24 mr-1 mb-2 bg-theme-6 text-white inline-flex items-center">
                                توقف
                                <i data-loading-icon="puff" data-color="white" class="w-4 h-4 ml-auto"></i>
                            </button>
                            <button id="play" class="button w-24 mr-1 mb-2 bg-theme-9 text-white" style="display: none">
                                پخش
                            </button>
                            <button id="download" class="button w-24 mr-1 mb-2 bg-theme-1 text-white"
                                    style="display: none">
                                دانلود
                            </button>
                        </div>
                        <video id="recorded" playsinline loop></video>
                    </div>
                </div>
            </div>
            <div class="col-span-12 lg:col-span-4 xxl:col-span-3">
                <div class="intro-y">
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
                            <div class="intro-x box">
                                <div class="px-4 py-5 flex-auto">
                                    <div class="tab-content tab-space">
                                        <div class="block" id="tab-input">
                                            <div>
                                                <input type="radio" id="capture" name="input_type" value="capture">
                                                <label for="capture">دوربین</label><br>
                                                <input type="radio" id="file" name="input_type" value="file" checked>
                                                <label for="file">فایل</label><br>
                                            </div>
                                            <div>
                                                <div class="mt-2" id="choose_input_file">
                                                    <div id="dropzone" style="min-height: unset; padding: 2px 4px;"
                                                         class="custom-dropzone needsclick border-gray-200 border-dashed dz-clickable .border-gray-200"
                                                         data-action="{{ route('upload.temp') }}">
                                                        <div class="dz-message">
                                                            <div><i class="fas fa-plus"></i></div>
                                                            <div>انتخاب کنید</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <label for="top_offset">بالا</label>
                                                <input type="number" id="top_offset" class="input w-full border mt-2"
                                                       value="10" min="0">
                                            </div>
                                            <div class="mt-2">
                                                <label for="right_offset">راست</label>
                                                <input type="number" id="right_offset" class="input w-full border mt-2"
                                                       value="0" min="0">
                                            </div>
                                            <div class="mt-2">
                                                <label for="left_offset">چپ</label>
                                                <input type="number" id="left_offset" class="input w-full border mt-2"
                                                       value="0" min="0">
                                            </div>
                                            <div class="mt-2">
                                                <label for="bottom_offset">پایین</label>
                                                <input type="number" id="bottom_offset" class="input w-full border mt-2"
                                                       value="0" min="0">
                                            </div>
                                        </div>
                                        <div class="hidden" id="tab-screen">
                                            <div>
                                                <label for="screen_color">رنگ پرده</label>
                                                <input type="color" id="screen_color" value="#00ff00"
                                                       class="w-full border bg-gray-100 mt-2">
                                            </div>

                                            <div class="mt-3">
                                                <label for="screen_red_range" class="mb-2">قرمز</label>
                                                <input type="text" id="screen_red_range" value=""/>
                                            </div>
                                            <div class="mt-2">
                                                <label for="screen_green_range" class="mb-2">سبز</label>
                                                <input type="text" id="screen_green_range" value=""/>
                                            </div>
                                            <div class="mt-2">
                                                <label for="screen_blue_range" class="mb-2">آبی</label>
                                                <input type="text" id="screen_blue_range" value=""/>
                                            </div>
                                        </div>
                                        <div class="hidden" id="tab-asset">
                                            <div>
                                                <label for="background_image"
                                                       class="d-block mb-2">تصویر زمینه</label>
                                                <div id="background_dropzone" style="min-height: unset; padding: 2px 4px;"
                                                     class="custom-dropzone needsclick border-gray-200 border-dashed dz-clickable .border-gray-200"
                                                     data-action="{{ route('upload.temp') }}">
                                                    <div class="dz-message">
                                                        <div><i class="fas fa-plus"></i></div>
                                                        <div>انتخاب کنید</div>
                                                    </div>
                                                </div>

                                                <a id="back_to_asset_cat" class="my-4" style="display: none">
                                                    <i class="fad fa-arrow-circle-left float-right"
                                                       style="font-size: 1.3rem; color: #d53f8c"></i>
                                                </a>

                                                <div id="asset_categories" class="mt-4">
                                                    @foreach($assetCategories as $category)
                                                        <a onclick="showAssets({{ $category->id }})"
                                                           class="category d-block mt-2">
                                                            <div class="w-full flex flex-col lg:flex-row items-center">
                                                                <div class="w-16 h-16 image-fit">
                                                                    <img alt="{{ $category->name }}" class="rounded-md"
                                                                         src="{{ $category->image_url }}">
                                                                </div>
                                                                <div
                                                                    class="lg:ml-4 text-center lg:text-left mt-3 lg:mt-0">
                                                                    <div class="font-medium">
                                                                        {{ $category->name }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    @endforeach
                                                </div>
                                                <div id="assets">
                                                    @foreach($assetCategories as $category)
                                                        <div id="asset_{{ $category->id }}" class="asset">
                                                            @foreach($category->assets as $asset)
                                                                <a onclick="setAsset('{{ $asset->path_url }}')"
                                                                   class="category d-block mt-2">
                                                                    <div
                                                                        class="w-full flex flex-col lg:flex-row items-center">
                                                                        <div class="">
                                                                            <img alt="{{ $asset->name }}"
                                                                                 class="rounded-md"
                                                                                 src="{{ $asset->thumbnail_url }}">
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 lg:col-span-4 xxl:col-span-3 lg:block">
                            <div class="intro-y">
                                <div class="flex flex-wrap" id="tabs-id">
                                    <div class="w-full">
                                        <ul class="flex mb-0 list-none flex-wrap pb-4 flex-col">
                                            <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                                                <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-white bg-pink-600"
                                                   onclick="changeActiveTab(event,'tab-input')">
                                                    <i class="fas fa-video text-base mr-1"></i> تنظیمات ورودی
                                                </a>
                                            </li>
                                            <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                                                <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-pink-600 bg-white"
                                                   onclick="changeActiveTab(event,'tab-screen')">
                                                    <i class="fas fa-video text-base mr-1"></i> تنظیمات پرده
                                                </a>
                                            </li>
                                            <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                                                <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-pink-600 bg-white"
                                                   onclick="changeActiveTab(event,'tab-asset')">
                                                    <i class="fas fa-image text-base mr-1"></i> تنظیمات زمینه
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('vendor/p5js/p5.min.js') }}"></script>
    <script src="{{ asset('vendor/ion.rangeSlider/js/ion.rangeSlider.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/dropzone-5.7.0/min/dropzone.min.js') }}"></script>

    <script type="text/javascript">
        let defaultCanvasBg = '{{ asset('images/test.jpg') }}';
        let streamServerDomain = '{{ $socketServerUrl }}';
        let authToken = 'token';
    </script>

    <script type="text/javascript" src="{{ m(asset('dashboard_assets/js/pages/studio/playout.js')) }}"></script>
@endsection

