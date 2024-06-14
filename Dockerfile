# Use the latest Ubuntu as the base image
FROM ubuntu:latest

# Set environment variables
ENV DEBIAN_FRONTEND=noninteractive

# Update the package repository and install necessary packages in one RUN statement
RUN apt-get update && \
    apt-get install -y \
    software-properties-common \
    lsb-release \
    apt-transport-https \
    wget \
    git \
    unzip \
    curl \
    apache2 \
    libapache2-mod-php \
    gnupg \
    mysql-server \
    python3 python3-pip \
    phpmyadmin \
    ffmpeg libsm6 libxext6 && \
    curl -sL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get -y install nodejs && \
    add-apt-repository ppa:ondrej/php -y && \
    apt-get update && \
    apt-get install -y \
    php \
    php-cli \
    php-fpm \
    php-json \
    php-common \
    php-mysql \
    php-xml \
    php-mbstring \
    php-zip \
    php-curl \
    php-gd \
    php-bcmath \
    php-intl \
    php-ldap \
    php-imagick && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Clone the Laravel repository
RUN git clone https://github.com/codeterrayt/Finterprint2.git /var/www/laravel

# Set working directory to Laravel application
WORKDIR /var/www/laravel

# Install PHP dependencies using Composer
RUN composer install

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install npm dependencies and build assets
RUN npm install && npm run build

# Generate Laravel application key
RUN php artisan key:generate

# Create symbolic link for storage
RUN php artisan storage:link

# Fix MySQL permissions
RUN usermod -d /var/lib/mysql/ mysql

# Update rc.d for MySQL
RUN update-rc.d mysql defaults

# Install Python dependencies
RUN pip3 install -r python/req.txt --break-system-packages

RUN chmod +x /var/www/laravel/start.sh

# Expose necessary ports
EXPOSE 80 3306 8000

# Start MySQL and Apache services and run Laravel queue worker
CMD ["/bin/bash", "./start.sh"]
