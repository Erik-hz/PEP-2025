FROM php:8.2-apache

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_mysql zip

# Activar mod_rewrite de Apache
RUN a2enmod rewrite

# Copiar proyecto Laravel
COPY . /var/www/html/

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instalar dependencias en el contenedor
RUN composer install --no-dev --optimize-autoloader --working-dir=/var/www/html/

# Configurar permisos correctos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chown -R www-data:www-data /var/www/html/storage \
    && chmod -R 775 /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Exponer puerto
EXPOSE 80

CMD ["apache2-foreground"]
