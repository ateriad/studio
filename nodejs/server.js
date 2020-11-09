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
        const streamId = response.data['id']
        const fileName = response.data['file']
        const ext = fileName.split('.').pop();
        const path = '/app/laravel/storage/app/public/' + fileName;
        const flvPath = path.replace(ext, "flv");
        const dir = path.replace(/[^\/]*$/, '');

        if (!fs.existsSync(dir)) {
            fs.mkdirSync(dir, {
                recursive: true
            });
        }

        const ffmpeg = child_process.spawn('ffmpeg', [
            '-i', '-', '-c:v', 'libx264', '-preset', 'slow', '-f', 'flv', flvPath
        ]);

        ffmpeg.on('close', (code, signal) => {
            streamEnded(userToken, streamId, flvPath, path).then(function () {
                ws.terminate();
            });
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
        });

    }).catch(function (error) {
        console.log(error);
        ws.terminate();
    })
});

async function streamEnded(userToken, streamId, flvPath, path) {
    await convert(flvPath, path);
    await sendFinishStatus(userToken, streamId);
}

async function convert(flvPath, path) {
    child_process.exec("ffmpeg -i " + flvPath + " -c:v libx265 " + path,
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