const child_process = require('child_process');

const express = require('express');
const WebSocketServer = require('ws').Server;
const http = require('http');
const fs = require('fs');
const axios = require('axios');

const app = express();
const server = http.createServer(app).listen(3000, () => {
    console.log('Listening...');
});

const wss = new WebSocketServer({
    server: server
});


app.use((req, res, next) => {
    console.log('HTTP Request: ' + req.method + ' ' + req.originalUrl);
    return next();
});

app.use(express.static(__dirname + '/www'));


wss.on('connection', (ws, req) => {
    let match;
    if (!(match = req.url.match(/^\/stream\/(.*)$/))) {
        ws.terminate();
        return;
    }
    const userToken = match[1];

    axios.post('http://nginx/api/v1/stream/start',
        {},
        {
            headers: {
                Authorization: 'Bearer ' + userToken,
            }
        }
    ).then(function (response) {
        let streamId = response.data['id']
        let fileName = response.data['file']
        let ext = fileName.split('.').pop();
        let path = '/app/laravel/storage/app/public/' + fileName;
        let flvPath = path.replace(ext, "flv");
        let dir = path.replace(/[^\/]*$/, '');


        if (!fs.existsSync(dir + 'thumbs/')) {
            fs.mkdirSync(dir + 'thumbs/', {
                recursive: true
            });
        }

        const ffmpeg = child_process.spawn('ffmpeg', [
            '-i', '-', '-c:v', 'libx264', '-preset', 'slow', '-f', 'flv', flvPath
        ]);

        ffmpeg.on('close', (code, signal) => {
            ws.terminate();
        });

        ffmpeg.stdin.on('error', (e) => {
        });

        ffmpeg.stderr.on('data', (data) => {
            console.log('FFmpeg STDERR:', data.toString());
        });

        ws.on('message', (msg) => {
            ffmpeg.stdin.write(msg);
        });

        ws.on('close', (e) => {
            ffmpeg.kill('SIGINT');

            streamEnded(userToken, streamId, flvPath, path).then(function () {
                console.log('finished')
            });
        });

    }).catch(function (error) {
        console.log(error);
        ws.terminate();
    })
});

async function streamEnded(userToken, streamId, flvPath, path) {
    await sendFinishStatus(userToken, streamId);
    await convert(flvPath, path);
    await createThumb(flvPath);
}

async function convert(flvPath, path) {
    child_process.exec("ffmpeg -i " + flvPath + " -c:v libx264 " + path,
        (error, stdout, stderr) => {
            if (error) {
                return;
            }
            if (stderr) {
                return;
            }
        }
    );
}

async function sendFinishStatus(userToken, streamId) {
    axios.post('http://nginx/api/v1/stream/finish/' + streamId,
        {
            'status': 3
        },
        {
            headers: {
                Authorization: 'Bearer ' + userToken,
            }
        }
    ).then(function (response) {
        console.log('success');
    }).catch(function (error) {
        console.log(error);
    })
}

async function createThumb(path) {
    let dir = path.replace(/[^\/]*$/, '');
    let pngPath = path.replace(dir, dir + 'thumbs/').replace('flv', "png");

    child_process.exec("ffmpeg -i " + path + " -ss 00:00:02.000 -vframes 1 " + pngPath,
        (error, stdout, stderr) => {
            console.log(stderr);
        }
    );
}