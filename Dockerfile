# Usamos PHP 8.2 con Apache
FROM php:8.2-apache

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    libonig-dev libzip-dev zip unzip git \
    && docker-php-ext-install pdo pdo_mysql zip

# Habilitar mod_rewrite para rutas amigables
RUN a2enmod rewrite

# Copiar todo el proyecto al contenedor
COPY . /var/www/html/

# Cambiar el DocumentRoot a la carpeta 'public'
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Instalar Composer (si no viene ya)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instalar dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader --working-dir=/var/www/html
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql


# Ajustar permisos para Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chown -R www-data:www-data /var/www/html/storage \
    && chmod -R 775 /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Exponer puerto 80
EXPOSE 80

# Comando por defecto
CMD ["apache2-foreground"]
