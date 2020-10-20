@extends('pages.dashboard._layout')

@section('title', trans('pages/general.dashboard'))
@section('mobile_studio', 'menu--active')
@section('side_studio', 'side-menu--active')

@section('style')
    <style>
        #studio canvas {
            display: block;
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
        <h2 class="text-lg font-medium mr-auto">
            {{ trans('pages/general.studio') }}
        </h2>
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
                <div class="intro-y">
                    <div id="studio">
                        studio
                        <div id='canvas-container'></div>
                    </div>
                </div>
            </div>
            <div class="col-span-12 lg:col-span-4 xxl:col-span-3">
                <div class="intro-y">
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
                            <div class="intro-y box">
                                <div class="px-4 py-5 flex-auto">
                                    <div class="tab-content tab-space">
                                        <div class="block" id="tab-setting">
                                            <div>
                                                <label for="bg_color">رنگ زمینه</label>
                                                <input type="color" id="bg_color"
                                                       class="w-full border bg-gray-100 mt-2">
                                            </div>
                                        </div>
                                        <div class="hidden" id="tab-asset">
                                            <div class="intro-y">
                                                <label for="background_image"
                                                       class="d-block mb-2">تصویر زمینه</label>
                                                <input type="file"
                                                       class="input w-full border flex-1"
                                                       id="background_image" name="background_image"
                                                       placeholder="تصویر زمینه">

                                                <div id="assets">
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
                                                   onclick="changeActiveTab(event,'tab-setting')">
                                                    <i class="fas fa-cog text-base mr-1"></i> تنظیمات
                                                </a>
                                            </li>
                                            <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                                                <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-pink-600 bg-white"
                                                   onclick="changeActiveTab(event,'tab-asset')">
                                                    <i class="fas fa-image text-base mr-1"></i> زمینه
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
    <script type="text/javascript">
        function changeActiveTab(event, tabID) {
            let element = event.target;
            while (element.nodeName !== "A") {
                element = element.parentNode;
            }
            ulElement = element.parentNode.parentNode;
            aElements = ulElement.querySelectorAll("li > a");
            tabContents = document.querySelectorAll(".tab-content > div");
            for (let i = 0; i < aElements.length; i++) {
                aElements[i].classList.remove("text-white");
                aElements[i].classList.remove("bg-pink-600");
                aElements[i].classList.add("text-pink-600");
                aElements[i].classList.add("bg-white");
                tabContents[i].classList.add("hidden");
                tabContents[i].classList.remove("block");
            }
            element.classList.remove("text-pink-600");
            element.classList.remove("bg-white");
            element.classList.add("text-white");
            element.classList.add("bg-pink-600");
            document.getElementById(tabID).classList.remove("hidden");
            document.getElementById(tabID).classList.add("block");
        }

        function showAssets(categoryId) {
            alert(categoryId)
        }
    </script>

    <script>
        function hexToRgb(hex) {
            var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
            return result ? {
                r: parseInt(result[1], 16),
                g: parseInt(result[2], 16),
                b: parseInt(result[3], 16)
            } : null;
        }

        let bgColorElem = document.getElementById("bg_color");
        let capture;

        function setup() {
            bg = loadImage('{{ asset('images/test.jpg') }}');
            myCanvas = createCanvas(390, 240);
            myCanvas.parent('canvas-container');

            capture = createCapture(VIDEO);
            capture.size(320, 240);
            capture.hide();
        }

        function draw() {
            background(bg);
            let bColor = hexToRgb(bgColorElem.value)
            const rValue = bColor.r;
            const gValue = bColor.g;
            const bValue = bColor.b;

            capture.loadPixels();
            let l = capture.pixels.length / 4;

            for (let i = 0; i < l; i++) {
                let r = capture.pixels[i * 4 + 0];
                let g = capture.pixels[i * 4 + 1];
                let b = capture.pixels[i * 4 + 2];
                if (r > rValue && g > gValue && b > bValue) {
                    capture.pixels[i * 4 + 3] = 0;
                }
            }
            capture.updatePixels();

            image(capture, 0, 0, 320, 240);

        }

        // set background

        document.getElementById('background_image').addEventListener("change", function (e) {
            var file = e.target.files[0];
            var reader = new FileReader();
            reader.onload = function (f) {
                var data = f.target.result;
                bg = loadImage(data);
            };
            reader.readAsDataURL(file);
        });
    </script>
@endsection

