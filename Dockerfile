# Imagen base oficial de PHP 8.2 con Apache
FROM php:8.2-apache

# Instalar extensiones de PHP necesarias para Laravel
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_mysql zip

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Copiar archivos del proyecto
COPY . /var/www/html

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Ejecutar Composer dentro del contenedor
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Dar permisos a Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Exponer el puerto 80
EXPOSE 80

CMD ["apache2-foreground"]
