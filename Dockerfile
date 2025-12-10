FROM php:8.2-apache

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_mysql zip

# Activar mod_rewrite
RUN a2enmod rewrite

# Copiar solo la carpeta donde realmente está Laravel
COPY pep/ /var/www/html/

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instalar dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader --working-dir=/var/www/html/

# Permisos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Exponer puerto
EXPOSE 80

CMD ["apache2-foreground"]
