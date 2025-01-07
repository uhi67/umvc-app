# syntax=docker/dockerfile:1.7-labs
ARG VERSION=latest
FROM composer:latest AS version
WORKDIR "/app"
COPY --chown=www-data:www-data --exclude=vendor . /app
RUN git config --global --add safe.directory "/app"
RUN git describe --tags --abbrev=0 > version


FROM composer:latest AS composer
ARG COMPOSER_PREFER="--prefer-dist"
COPY composer.json composer.lock ./

# SSH info
RUN mkdir -p -m 0700 ~/.ssh
RUN mkdir -p -m 0700 /var/www/.ssh && chown -R www-data:www-data /var/www/.ssh
RUN ssh-keyscan github.com >> ~/.ssh/known_hosts
RUN ssh-keyscan github.com >> /var/www/.ssh/known_hosts
RUN ssh-keyscan bitbucket.org >> ~/.ssh/known_hosts
RUN ssh-keyscan bitbucket.org >> /var/www/.ssh/known_hosts
#RUN --mount=type=ssh ssh git@github.com 2>&1 | grep "Hi .*!" # checking ssh identity

RUN echo "Composer option is $COMPOSER_PREFER"
RUN --mount=type=ssh --mount=type=cache,target=/tmp/cache composer install --no-dev --ignore-platform-reqs --no-scripts -n $COMPOSER_PREFER


FROM php:8.3-apache
ARG DEBIAN_FRONTEND=noninteractive
ENV SIMPLESAMLPHP_CONFIG_DIR="/app/config/saml/config"

RUN apt-get update -qq && ACCEPT_EULA=Y apt-get upgrade -y -qq
RUN apt-get install -y libicu-dev git libbz2-1.0 libbz2-dev libssl-dev libzip-dev
RUN apt-get install -y unzip
RUN apt-get install -y sudo
RUN docker-php-ext-install bz2 intl
RUN docker-php-ext-install mysqli phar
RUN docker-php-ext-install zip pdo_mysql

RUN php -r "readfile('http://getcomposer.org/installer');" \
    | php -- --install-dir=/usr/bin/ --filename=composer

RUN a2enmod ssl
RUN a2enmod rewrite

WORKDIR /var/www/

COPY --chown=www-data:www-data --exclude=vendor --exclude=.git --exclude=version . /app
COPY --from=composer --chown=www-data:www-data /app/vendor /app/vendor
COPY --from=version /app/version /app/version

COPY --chown=root:root docker/https.conf /etc/apache2/sites-available
COPY --chown=root:root docker/saml.conf /etc/apache2/conf-available
RUN rm -rf /var/www/html && ln -sf /app/www /var/www/html
RUN a2enconf saml
RUN a2enmod rewrite

RUN mkdir -m 777 /app/runtime && chown www-data /app/runtime
RUN mkdir -m 777 /app/runtime/cache && chown www-data /app/runtime/cache
RUN mkdir -m 777 /app/runtime/logs && chown www-data /app/runtime/logs
RUN mkdir -m 777 /app/runtime/mdx-cache && chown www-data /app/runtime/mdx-cache
RUN mkdir -m 777 /app/runtime/saml && chown www-data /app/runtime/saml
RUN mkdir -m 777 /app/www/assets/cache && chown www-data /app/www/assets/cache

WORKDIR /app
COPY docker/entrypoint.sh /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
