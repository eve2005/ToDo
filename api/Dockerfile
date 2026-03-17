FROM php:8.2-cli

RUN apt-get update && apt-get install -y zip unzip git && docker-php-ext-install pdo_mysql

WORKDIR /api
COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY . .
RUN composer install



RUN chmod +x /api/start.sh
EXPOSE 8000

CMD ["/api/start.sh"]