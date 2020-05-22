# FROM debian:buster-slim

# # System deps
# RUN apt-get update \
#     && DEBIAN_FRONTEND=noninteractive apt-get upgrade -yq \
#     && DEBIAN_FRONTEND=noninteractive apt-get install -yq --no-install-recommends \
#     software-properties-common \
#     systemd-sysv \
#     htop \
#     nfs-common \
#     binutils \
#     systemd \
#     make \
#     apt-utils \
#     apt-transport-https \
#     ca-certificates \
#     locales \
#     && apt-get update \
#     && DEBIAN_FRONTEND=noninteractive apt-get install -yq \
#     libfreetype6-dev \
#     libicu-dev \
#     libssl1.1 \
#     libmcrypt-dev \
#     libedit-dev \
#     libedit2 \
#     libxslt1-dev \
#     gnupg \
#     redis-tools \
#     mariadb-client \
#     git \
#     vim \
#     wget \
#     curl \
#     lynx \
#     psmisc \
#     unzip \
#     tar \
#     # cron \
#     bash-completion \
#     nginx \
#     # varnish \
#     nodejs \
#     npm \
#     libnode-dev \
#     node-gyp \
#     supervisor \
#     && apt-get clean

# RUN apt -y autoremove \
#     && apt-get clean

# RUN mkdir -p /var/run/

# RUN wget -q https://packages.sury.org/php/apt.gpg -O- | apt-key add -
# RUN echo "deb https://packages.sury.org/php/ buster main" | tee /etc/apt/sources.list.d/php.list
# RUN apt update

# # PHP deps
# RUN DEBIAN_FRONTEND=noninteractive apt-get install -yq --no-install-recommends php7.3 \
#     php7.3-ctype \
#     php7.3-gd \
#     php7.3-dom \
#     php7.3-simplexml \
#     php7.3-iconv \
#     php7.3-intl \
#     php7.3-xsl \
#     php7.3-mbstring \
#     php7.3-zip \
#     php7.3-soap \
#     php7.3-xml \
#     php7.3-fpm \
#     php-xdebug \
#     php7.3-bcmath \
FROM php:7.4-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo pdo_mysql

RUN a2enmod rewrite

COPY ./config/php/php.ini $PHP_INI_DIR/conf.d/

COPY ./config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY ./config/apache/site.conf /etc/apache2/sites-available
COPY ./config/apache/site.conf /etc/apache2/sites-enabled
COPY ./config/php/xdebug.ini /etc/php/7.3/mods-available/xdebug.ini
COPY ./entrypoint.sh /entrypoint.sh

WORKDIR /var/www/html