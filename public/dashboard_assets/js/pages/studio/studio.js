// page scripts
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
    let ulElement = element.parentNode.parentNode;
    let aElements = ulElement.querySelectorAll("li > a");
    let tabContents = document.querySelectorAll(".tab-content > div");
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

$('input[type=radio][name=input_type]').change(function () {
    if (this.value === 'capture') {
        $('#choose_input_file').addClass('hidden');
        useFile = false;
        useCapture = true;

        capture = createCapture({
            video: true
        });
        capture.size(320, 240);
        capture.hide();
        k = 0;


    } else if (this.value === 'file') {
        $('#choose_input_file').removeClass('hidden');
        useFile = true;
        useCapture = false;

        capture = null;
        k = 0;
    }
});

let myDropzone = new Dropzone("#dropzone", {
    url: $('#dropzone').data('action'),
    method: 'post',
    headers: {
        'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
    },
    paramName: "file",
    maxFiles: 1,
    acceptedFiles: 'video/*',
    dictInvalidFileType: 'فایل قابل قبول نمیباشد.',
    thumbnailMethod: 'contain',
    addRemoveLinks: true,
    dictRemoveFile: '✘',
    init: function () {
        this.on("removedfile", function (file) {
            $('#image').val('');
        });

        this.on("success", function (file, responseText) {
            inputVideoSrc = window.location.origin + '/storage/' + responseText.path;
            video = createVideo([inputVideoSrc]);
            video.loop();
            video.volume(0);
            video.hide();
            k = 0;
        });

        this.on("maxfilesexceeded", function (file) {
            this.removeAllFiles();
            this.addFile(file);
        });
    }
});


// canvas scripts
let screenColorElem = document.getElementById("screen_color");
let canvasParent = document.getElementById('studio');
let useFile, useCapture, capture, inputVideoSrc = null, video = null;
useFile = true;
useCapture = false;
let k = 0;

let screenRedRangeElem = $("#screen_red_range");
let screenGreenRangeElem = $("#screen_green_range");
let screenBlueRangeElem = $("#screen_blue_range");
let screenRedRangeValues, screenGreenRangeValues, screenBlueRangeValues;
screenRedRangeValues = screenGreenRangeValues = screenBlueRangeValues = {
    'from': 0,
    'to': 0,
};

function componentToHex(c) {
    let hex = c.toString(16);
    return hex.length === 1 ? "0" + hex : hex;
}

function rgbToHex(r, g, b) {
    return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
}

function hexToRgb(hex) {
    let result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}

function setDefaultScreenColor(pixels) {
    let rSum = 0, gSum = 0, bSum = 0;
    for (let i = 4000; i < 4100; i++) {
        rSum += pixels[i * 4];
        gSum += pixels[i * 4 + 1];
        bSum += pixels[i * 4 + 2];
    }
    screenColorElem.value = rgbToHex(parseInt(rSum / 100), parseInt(gSum / 100), parseInt(bSum / 100));

    let event = new Event('change');
    screenColorElem.dispatchEvent(event);
}

function removePixels(screenRedRangeValues, screenGreenRangeValues, screenBlueRangeValues, r, g, b) {
    return (
        screenRedRangeValues.from < r && r < screenRedRangeValues.to &&
        screenGreenRangeValues.from < g && g < screenGreenRangeValues.to &&
        screenBlueRangeValues.from < b && b < screenBlueRangeValues.to
    )
}

screenRedRangeElem.ionRangeSlider({
    type: "double",
    skin: "round",
    min: 0,
    max: 255,
    from: 0,
    to: 50,
    grid: true,
    onChange: function (data) {
        screenRedRangeValues = {
            'from': data.from,
            'to': data.to,
        }
    },
    onUpdate: function (data) {
        screenRedRangeValues = {
            'from': data.from,
            'to': data.to,
        }
    },
});
screenGreenRangeElem.ionRangeSlider({
    type: "double",
    skin: "round",
    min: 0,
    max: 255,
    from: 200,
    to: 255,
    grid: true,
    onChange: function (data) {
        screenGreenRangeValues = {
            'from': data.from,
            'to': data.to,
        }
    },
    onUpdate: function (data) {
        screenGreenRangeValues = {
            'from': data.from,
            'to': data.to,
        }
    },
});
screenBlueRangeElem.ionRangeSlider({
    type: "double",
    skin: "round",
    min: 0,
    max: 255,
    from: 0,
    to: 50,
    grid: true,
    onChange: function (data) {
        screenBlueRangeValues = {
            'from': data.from,
            'to': data.to,
        }
    },
    onUpdate: function (data) {
        screenBlueRangeValues = {
            'from': data.from,
            'to': data.to,
        }
    },
});

let screenRedRange = screenRedRangeElem.data("ionRangeSlider");
let screenGreenRange = screenGreenRangeElem.data("ionRangeSlider");
let screenBlueRange = screenBlueRangeElem.data("ionRangeSlider");

screenColorElem.addEventListener("change", function () {
    let value = hexToRgb(screenColorElem.value);

    screenRedRange.update({
        from: value.r - 30,
        to: value.r + 30
    });
    screenGreenRange.update({
        from: value.g - 30,
        to: value.g + 30
    });
    screenBlueRange.update({
        from: value.b - 30,
        to: value.b + 30
    });
});

let mediaStream = new MediaStream();

function setup() {
    bg = loadImage(defaultCanvasBg);
    myCanvas = createCanvas(450, 340);
    myCanvas.parent('canvas-container');
    resizeCanvas(canvasParent.offsetWidth, canvasParent.offsetHeight);
    noStroke();
    noFill();
    enableRecording();
}

function draw() {
    background(bg);

    if (useCapture && capture) {
        capture.loadPixels();

        k++;
        if (k === 60) {
            setDefaultScreenColor(capture.pixels)
        }

        let l = capture.pixels.length / 4;
        for (let i = 0; i < l; i++) {
            let r = capture.pixels[i * 4];
            let g = capture.pixels[i * 4 + 1];
            let b = capture.pixels[i * 4 + 2];

            if (r !== 0 || g !== 0 || b !== 0) {
                if (removePixels(screenRedRangeValues, screenGreenRangeValues, screenBlueRangeValues, r, g, b)) {
                    capture.pixels[i * 4 + 3] = 0;
                }
            }
        }
        capture.updatePixels();

        image(capture, 10, 10, canvasParent.offsetWidth - 20, canvasParent.offsetHeight - 10);
    }

    if (useFile && video != null) {
        video.loadPixels();

        k++;
        if (k === 60) {
            setDefaultScreenColor(video.pixels)
        }

        let l = video.pixels.length / 4;
        for (let i = 0; i < l; i++) {
            let r = video.pixels[i * 4];
            let g = video.pixels[i * 4 + 1];
            let b = video.pixels[i * 4 + 2];

            if (r !== 0 || g !== 0 || b !== 0) {
                if (removePixels(screenRedRangeValues, screenGreenRangeValues, screenBlueRangeValues, r, g, b)) {
                    video.pixels[i * 4 + 3] = 0;
                }
            }
        }
        video.updatePixels();

        image(video, 10, 10, canvasParent.offsetWidth - 20, canvasParent.offsetHeight - 10);
    }
}

// set background
document.getElementById('background_image').addEventListener("change", function (e) {
    let file = e.target.files[0];
    let type = file.type;

    var reader = new FileReader();
    reader.onload = function (f) {
        var buffer = f.target.result;
        if (type.includes("image")) {
            bg = loadImage(buffer);
        }
    };

    if (type.includes("image")) {
        reader.readAsDataURL(file);
    }
});

function setAsset(url) {
    console.log(url, 'url')
    bg = loadImage(url);
}

//record stream
let mediaRecorder;
let recordedBlobs;

const errorMsgElement = document.querySelector('span#errorMsg');
const recordedVideo = document.querySelector('video#recorded');
const recordButton = document.querySelector('button#record');
const stopRecordingButton = document.querySelector('button#stop_recording');

recordButton.addEventListener('click', () => {
    startRecording();
});
stopRecordingButton.addEventListener('click', () => {
    stopRecording();
    stopRecordingButton.style.display = "none";
    recordButton.style.display = "inline-block";
    playButton.disabled = false;
    downloadButton.disabled = false;
});

const playButton = document.querySelector('button#play');
playButton.addEventListener('click', () => {
    const superBuffer = new Blob(recordedBlobs, {type: 'video/webm'});
    recordedVideo.src = null;
    recordedVideo.srcObject = null;
    recordedVideo.src = window.URL.createObjectURL(superBuffer);
    recordedVideo.controls = true;
    recordedVideo.play();
});

const downloadButton = document.querySelector('button#download');
downloadButton.addEventListener('click', () => {
    const blob = new Blob(recordedBlobs, {type: 'video/webm'});
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.style.display = 'none';
    a.href = url;
    a.download = 'test.webm';
    document.body.appendChild(a);
    a.click();
    setTimeout(() => {
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    }, 100);
});

function handleDataAvailable(event) {
    console.log('handleDataAvailable', event);
    if (event.data && event.data.size > 0) {
        recordedBlobs.push(event.data);
    }
}

function startRecording() {
    recordedBlobs = [];
    let options = {mimeType: 'video/webm;codecs=vp9,opus'};
    if (!MediaRecorder.isTypeSupported(options.mimeType)) {
        console.error(`${options.mimeType} is not supported`);
        options = {mimeType: 'video/webm;codecs=vp8,opus'};
        if (!MediaRecorder.isTypeSupported(options.mimeType)) {
            console.error(`${options.mimeType} is not supported`);
            options = {mimeType: 'video/webm'};
            if (!MediaRecorder.isTypeSupported(options.mimeType)) {
                console.error(`${options.mimeType} is not supported`);
                options = {mimeType: ''};
            }
        }
    }

    try {
        mediaRecorder = new MediaRecorder(window.mediaStream, options);
    } catch (e) {
        console.error('Exception while creating MediaRecorder:', e);
        errorMsgElement.innerHTML = `Exception while creating MediaRecorder: ${JSON.stringify(e)}`;
        return;
    }

    console.log('Created MediaRecorder', mediaRecorder, 'with options', options);
    recordButton.style.display = "none";
    stopRecordingButton.style.display = "inline-flex";
    stopRecordingButton.disabled = false;
    playButton.disabled = true;
    downloadButton.disabled = true;
    mediaRecorder.onstop = (event) => {
        console.log('Recorder stopped: ', event);
        console.log('Recorded Blobs: ', recordedBlobs);
    };
    mediaRecorder.ondataavailable = handleDataAvailable;
    mediaRecorder.start();
    console.log('MediaRecorder started', mediaRecorder);
}

function stopRecording() {
    mediaRecorder.stop();
}

function enableRecording() {
    let canvas = document.querySelector('canvas');
    mediaStream = canvas.captureStream(25);

    navigator.mediaDevices.getUserMedia({audio: true}).then(function (stream) {
        mediaStream.addTrack(stream.getTracks()[0])
    })

    recordButton.disabled = false;
    window.mediaStream = mediaStream;
}
