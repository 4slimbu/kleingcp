FROM webdevops/php-nginx-dev:8.3-alpine

# Install required packages
RUN apk add --no-cache curl

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP extensions and other packages
RUN docker-php-ext-install mysqli

# Start supervisord to manage services as non-root user
CMD ["supervisord", "-c", "/opt/docker/etc/supervisor.conf"]
