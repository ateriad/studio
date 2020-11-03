const child_process = require('child_process');

const express = require('express');
const WebSocketServer = require('ws').Server;
const http = require('http');
const fs = require('fs');
const axios = require('axios');

const app = express();
const index = http.createServer(app).listen(3000, () => {
    console.log('Listening...');
});

const wss = new WebSocketServer({
    server: index
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

    axios.get('http://nginx/api/v1/stream/create', {
        headers: {
            Authorization: 'Bearer ' + userToken,
        }
    }).then(function (response) {
        const fileName = response.data['fileName']
        const fileDirectory = '/app/laravel' + response.data['fileDirectory']

        if (!fs.existsSync(fileDirectory)) {
            fs.mkdirSync(fileDirectory, {
                recursive: true
            });
        }


        const ffmpeg = child_process.spawn('ffmpeg', [
            '-i', '-', '-c:v', 'libx264', '-preset', 'slow', '-f', 'flv', fileDirectory + fileName
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
        });

    }).catch(function (error) {
        console.log(error.response.data);
        ws.terminate();
    })
});
