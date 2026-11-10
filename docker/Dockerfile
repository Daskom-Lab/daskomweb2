# Runtime Laravel 13 di FrankenPHP.
#
# Sebelumnya tahap build menjalankan `docker-php-ext-install` tanpa
# menyiapkan toolchain, sehingga gagal dengan "re2c (no such package)".
# Ekstensi yang sudah ada di base image (posix, pdo_sqlite, sodium, ...)
# tidak dikompilasi ulang; hanya yang benar-benar dibutuhkan yang dibangun.

FROM dunglas/frankenphp:1.13.3-php8.4-alpine AS build

# Toolchain untuk kompilasi ekstensi: autoconf/make/g++ untuk phpize,
# re2c wajib bagi parser, dan header lib untuk redis/gd.
RUN apk add --no-cache \
        autoconf \
        dpkg \
        dpkg-dev \
        g++ \
        gcc \
        make \
        re2c \
        pkgconf \
        libc-dev \
        curl \
        linux-headers \
    && apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS

# pcntl + posix dibutuhkan laravel/horizon, pdo_mysql untuk MySQL,
# redis karena REDIS_CLIENT default-nya phpredis.
RUN docker-php-ext-install -j"$(nproc)" pcntl pdo_mysql

RUN pecl install redis \
    && docker-php-ext-enable redis

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


FROM dunglas/frankenphp:1.13.3-php8.4-alpine AS runtime

RUN apk add --no-cache supervisor

COPY --from=build /usr/local/bin/composer /usr/local/bin/composer
COPY --from=build /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d
COPY --from=build /usr/local/lib/php/extensions /usr/local/lib/php/extensions

COPY supervisord.conf /etc/supervisord.conf

COPY entrypoint.sh /entrypoint.sh
COPY Caddyfile /etc/caddy/Caddyfile
COPY verify-image.sh /usr/local/bin/verify-image.sh

RUN chmod +x /entrypoint.sh /usr/local/bin/verify-image.sh

WORKDIR /app

ENTRYPOINT ["/entrypoint.sh"]
