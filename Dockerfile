FROM wyveo/nginx-php-fpm:php80
WORKDIR /usr/share/nginx/
RUN rm -rf html
COPY . /usr/share/nginx/
RUN ln -s public html
RUN chmod -R 777 storage/
