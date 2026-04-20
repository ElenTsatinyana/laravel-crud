# Օգտագործում ենք պաշտոնական PHP պատկերը Apache-ով
FROM php:8.2-apache

# Տեղադրում ենք անհրաժեշտ համակարգային գրադարանները
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    git \
    curl

# Մաքրում ենք քեշը
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Տեղադրում ենք PHP ընդլայնումները (Ավելացվել է pdo_pgsql)
RUN docker-php-ext-install pdo_pgsql pdo_mysql mbstring exif pcntl bcmath gd

# Միացնում ենք Apache-ի rewrite մոդուլը
RUN a2enmod rewrite

# Տեղադրում ենք Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Պատճենում ենք նախագծի ֆայլերը
WORKDIR /var/www/html
COPY . .

# Տեղադրում ենք PHP-ի գրադարանները
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Փոխում ենք Apache-ի default folder-ը դեպի Laravel-ի public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Տալիս ենք թույլտվությունները
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Բացում ենք 80 պորտը
EXPOSE 80

# Աշխատեցնում ենք Migration-ը և մեկնարկում Apache-ն
CMD php artisan migrate --force && apache2-foreground