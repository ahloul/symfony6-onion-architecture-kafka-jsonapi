FROM php:8.1.1-fpm-alpine
ARG RDKAFKA_VERSION="1.1.0"
ARG RDKAFKA_PECL_VERSION="5.0.2"
# Setup working directory
WORKDIR /var/www

RUN apk add --no-cache openssl alpine-sdk autoconf bash vim
RUN set -ex \
  && apk --no-cache add \
    postgresql-dev
# Build, install and enable PHP rdkafka extension
RUN mkdir -p /tmp/librdkafka \
    && cd /tmp \
    && curl -L https://github.com/edenhill/librdkafka/archive/v${RDKAFKA_VERSION}.tar.gz | tar xz -C /tmp/librdkafka --strip-components=1 \
    && cd librdkafka \
    && ./configure \
    && make \
    && make install \
    && pecl install rdkafka-${RDKAFKA_PECL_VERSION} \
    && docker-php-ext-enable rdkafka \
    && rm -rf /tmp/librdkafka \

RUN pecl install rdkafka-5.0.2

RUN docker-php-ext-install pdo pdo_pgsql
RUN docker-php-ext-install sockets
RUN docker-php-ext-install  bcmath
RUN docker-php-ext-install  pcntl




RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

EXPOSE 9000
COPY code/entrypoint.sh /tmp/entrypoint.sh
RUN ["chmod", "+x", "/tmp/entrypoint.sh"]
RUN chown -R www-data:www-data /var/www
ENTRYPOINT ["/tmp/entrypoint.sh"]
