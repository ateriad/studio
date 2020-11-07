FROM ubuntu:18.04
USER root
ENV APP_DIR="/app"

WORKDIR ${APP_DIR}

RUN apt-get update && apt-get -y install curl ffmpeg
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get -y install nodejs
RUN npm install -g nodemon

EXPOSE 3000

CMD ["nodemon", "--watch", "nodejs", "nodejs/server.js"]