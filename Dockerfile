FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip 

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /src

COPY . .

RUN composer install --no-interaction --prefer-dist

CMD ["sh", "-c", "./vendor/bin/phpunit --testdox --colors=always app"]