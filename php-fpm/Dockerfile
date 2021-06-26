FROM php:7.3-fpm-alpine

RUN apk update \
    && apk add  --no-cache git curl libmcrypt libmcrypt-dev openssh-client icu-dev nodejs yarn \
    libxml2-dev freetype-dev libpng-dev libjpeg-turbo-dev g++ make autoconf \
    && docker-php-source extract \
    && docker-php-source delete \
    && docker-php-ext-install pdo soap intl \
#    && docker-php-ext-install pdo_sqlite \
#    && docker-php-ext-enable pdo_sqlite \
   && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && rm -rf /tmp/*

CMD ["php-fpm", "-F"]

WORKDIR /var/www/phone_manager

RUN composer install

RUN yarn install

RUN yarn encore prod

# RUN rm .env && cp .env.prod .env

EXPOSE 9000
