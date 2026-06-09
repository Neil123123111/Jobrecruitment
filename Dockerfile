FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql \
    && a2enmod rewrite

WORKDIR /var/www/html
COPY . /var/www/html
COPY docker-entrypoint-railway.sh /usr/local/bin/docker-entrypoint-railway.sh

# Keep upload directory writable in container runtime.
RUN mkdir -p /var/www/html/uploads/cv \
    && chown -R www-data:www-data /var/www/html/uploads \
    && chmod -R 775 /var/www/html/uploads \
    && chmod +x /usr/local/bin/docker-entrypoint-railway.sh

EXPOSE 8080

ENTRYPOINT ["docker-entrypoint-railway.sh"]
