FROM php:7.4-cli
WORKDIR /app
COPY . /app
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get update && \
    apt-get install -y zip && \
    composer install --dev
CMD ["vendor/bin/phpunit", "tests"]
