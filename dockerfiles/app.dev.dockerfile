FROM php:8.1-fpm

RUN apt-get update && apt-get install -y  \
    libfreetype6-dev \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    git-all \
    --no-install-recommends \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql -j$(nproc) gd

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
	php composer-setup.php && \
	php -r "unlink('composer-setup.php');" && \
	mv composer.phar /usr/local/sbin/composer && \
	chmod +x /usr/local/sbin/composer

RUN echo 'post_max_size = 32M' >> "$PHP_INI_DIR/conf.d/docker-env.ini"
RUN echo 'upload_max_filesize = 32M' >> "$PHP_INI_DIR/conf.d/docker-env.ini"

ARG UID=1000

RUN usermod -u ${UID} www-data && groupmod -g ${UID} www-data

USER www-data
