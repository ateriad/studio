FROM dockage/php:7.3.4-cli-alpine3.9

ENV APP_INSTALL_DIR="/app"

RUN apk --no-cache --update add \
        bash \
        supervisor \
        ffmpeg \
        composer \
        confd@testing \
        file \
        git \
        openssh-client \
        openssl \
        php7-bcmath \
        php7-ctype \
        php7-curl \
        php7-dom \
        php7-gd \
        php7-gettext \
        php7-iconv \
        php7-intl \
        php7-json \
        php7-mbstring \
        php7-mcrypt \
        php7-mysqli \
        php7-pdo_mysql \
        php7-phar \
        php7-session \
        php7-simplexml \
        php7-soap \
        php7-tokenizer \
        php7-xml \
        php7-xmlreader \
        php7-xmlwriter \
        php7-zip \
        php7-zlib \
        php7-redis \
        php7-xdebug \
        php7-pcntl \
        php7-posix

WORKDIR ${APP_INSTALL_DIR}
