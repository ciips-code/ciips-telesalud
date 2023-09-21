FROM php:8.1-fpm

RUN apt-get update && apt-get install -y  \
    libfreetype6-dev \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    libzip-dev \
    git-all \
    --no-install-recommends \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql zip bcmath -j$(nproc) gd

COPY --chown=www-data:www-data . /var/www

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
	php composer-setup.php && \
	php -r "unlink('composer-setup.php');" && \
	mv composer.phar /usr/local/sbin/composer && \
	chmod +x /usr/local/sbin/composer && \
	rm -rf docker-config dockerfiles docker-compose.yml docker-compose.dev.yml && \
	chmod -R 775 /var/www/storage /var/www/bootstrap/cache

RUN echo 'post_max_size = 32M' >> "$PHP_INI_DIR/conf.d/docker-env.ini"
RUN echo 'upload_max_filesize = 32M' >> "$PHP_INI_DIR/conf.d/docker-env.ini"

USER www-data

RUN cd /var/www && composer install
