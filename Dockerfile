FROM wyveo/nginx-php-fpm:php80
COPY .docker/nginx/conf.d/default.conf /etc/nginx/conf.d/
WORKDIR /usr/share/nginx/
COPY . /usr/share/nginx/
RUN chmod -R 777 storage/
RUN composer install --no-interaction --no-dev
