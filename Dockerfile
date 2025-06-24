FROM php:8.1-apache
RUN apt update && apt install -y net-tools libpq-dev python3 python3-pip
RUN a2enmod rewrite

RUN rm /etc/apache2/sites-enabled/000-default.conf

COPY docker/apache-custom.conf /etc/apache2/sites-available/000-default.conf

RUN a2ensite 000-default.conf

RUN docker-php-ext-install pgsql pdo_pgsql

RUN apt install -y python3-pandas

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

EXPOSE 80

