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

COPY composer.json /var/www/phone_manager/

COPY composer.lock /var/www/phone_manager/

WORKDIR /var/www/phone_manager

RUN composer install

COPY package.json /var/www/phone_manager/

COPY yarn.lock /var/www/phone_manager/

COPY webpack.config.js /var/www/phone_manager/

RUN yarn install

RUN yarn encore prod

# RUN rm .env && cp .env.prod .env

EXPOSE 9000
