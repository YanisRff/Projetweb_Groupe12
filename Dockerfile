# Use an official PHP image with Apache as the base.
FROM php:8.1-apache

# Install necessary system packages.
# Added libpq-dev for PostgreSQL client development headers and libraries.
RUN apt update && apt install -y net-tools libpq-dev

# Enable Apache's mod_rewrite module.
RUN a2enmod rewrite

# Remove the default Apache virtual host configuration.
RUN rm /etc/apache2/sites-enabled/000-default.conf

# Copy your custom Apache virtual host configuration file into the container.
COPY docker/apache-custom.conf /etc/apache2/sites-available/000-default.conf

# Enable the custom virtual host configuration.
RUN a2ensite 000-default.conf

# Install the PostgreSQL PHP extensions.
# Now libpq-dev is available, this step should succeed.
RUN docker-php-ext-install pgsql pdo_pgsql

# Copy your entire application code into the Apache web root inside the container.
COPY . /var/www/html/

# Set the correct ownership and permissions.
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Expose port 80.
EXPOSE 80
