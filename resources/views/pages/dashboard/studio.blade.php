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
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
                <div class="intro-y">
                    <div id="studio">
                        <div id='canvas-container'></div>
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
                                        <div class="block" id="tab-setting">
                                            <div>
                                                <label for="bg_color">رنگ پرده</label>
                                                <input type="color" id="bg_color"
                                                       class="w-full border bg-gray-100 mt-2">
                                            </div>
                                        </div>
                                        <div class="hidden" id="tab-asset">
                                            <div>
                                                <label for="background_image"
                                                       class="d-block mb-2">تصویر زمینه</label>
                                                <input type="file"
                                                       class="input w-full border flex-1"
                                                       id="background_image" name="background_image"
                                                       placeholder="تصویر زمینه">

                                                <div id="asset_categories">
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
                                                   onclick="changeActiveTab(event,'tab-setting')">
                                                    <i class="fas fa-video text-base mr-1"></i> تنظیمات ویدیو
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
    <script type="text/javascript">
        function changeActiveTab(event, tabID) {
            document.getElementById('asset_categories').style.display = "block";
            let ele = document.getElementsByClassName('asset');
            for (let i = 0; i < ele.length; i++) {
                ele[i].style.display = "none";
            }

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
            document.getElementById('asset_categories').style.display = "none";
            document.getElementById('asset_' + categoryId).style.display = "block";
        }
    </script>

    <script>
        function componentToHex(c) {
            let hex = c.toString(16);
            return hex.length === 1 ? "0" + hex : hex;
        }

        function rgbToHex(r, g, b) {
            return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
        }

        function hexToRgb(hex) {
            var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
            return result ? {
                r: parseInt(result[1], 16),
                g: parseInt(result[2], 16),
                b: parseInt(result[3], 16)
            } : null;
        }

        function setDefaultBgColor(pixels) {
            let rSum = 0, gSum = 0, bSum = 0;
            for (let i = 4000; i < 4500; i++) {
                rSum += pixels[i * 4];
                gSum += pixels[i * 4 + 1];
                bSum += pixels[i * 4 + 2];
            }
            bgColorElem.value = rgbToHex(parseInt(rSum / 500), parseInt(gSum / 500), parseInt(bSum / 500));
        }

        let bgColorElem = document.getElementById("bg_color");
        let canvasParent = document.getElementById('studio');
        let capture;
        let k = 0;

        function setup() {
            bg = loadImage('{{ asset('images/test.jpg') }}');
            myCanvas = createCanvas(450, 340);
            myCanvas.parent('canvas-container');
            resizeCanvas(canvasParent.offsetWidth, canvasParent.offsetHeight);

            capture = createCapture(VIDEO);
            capture.size(320, 240);
            capture.hide();
        }

        function draw() {
            background(bg);
            let bColor = hexToRgb(bgColorElem.value)

            capture.loadPixels();
            k++;
            if (k === 60) {
                setDefaultBgColor(capture.pixels)
            }

            let l = capture.pixels.length / 4;
            for (let i = 0; i < l; i++) {
                let r = capture.pixels[i * 4];
                let g = capture.pixels[i * 4 + 1];
                let b = capture.pixels[i * 4 + 2];
                if (r > bColor.r && g > bColor.g && b > bColor.b) {
                    capture.pixels[i * 4 + 3] = 0;
                }
            }
            capture.updatePixels();

            image(capture, 10, 10, canvasParent.offsetWidth - 20, canvasParent.offsetHeight - 10);
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

        function setAsset(url) {
            console.log(url, 'url')
            bg = loadImage(url);
        }
    </script>
@endsection

