FROM php:8.1-fpm-alpine

WORKDIR /app
COPY . /app

RUN apk update && apk add --no-cache \
build-base shadow vim curl libxml2-dev openssh curl zip php81-zip php81-openssl libzip-dev libwebp-dev icu perl libmcrypt-dev php81-mbstring jpeg-dev freetype-dev libpng-dev \
#RUN apk add jpeg-dev libpng-dev \
    && docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) gd \
    && apk add --update nodejs npm


RUN docker-php-ext-install pdo pdo_mysql bcmath zip
#RUN docker-php-ext-configure gd --enable-gd --with-jpeg --with-freetype --with-webp
#RUN docker-php-ext-install -j$(nproc) gd
# curl json mbstring tokenizer xml zip
RUN docker-php-ext-enable pdo_mysql bcmath

RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
RUN composer install
RUN echo $(npm -v)
RUN npm i --legacy-peer-deps

#CMD ["php","artisan","serve", "--host","0.0.0.0", "--port","80"]
CMD ["php","artisan","serve","--host","0.0.0.0","--port","80"]
EXPOSE 80
