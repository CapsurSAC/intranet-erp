FROM php:8.2-apache

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl

# Extensiones PHP necesarias para Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Cambiar DocumentRoot a /public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /var/www/html

# Copiar el proyecto
COPY . .

# Permisos
RUN chown -R www-data:www-data storage bootstrap/cache

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader
# Instalamos librerías del sistema
RUN apt-get update && apt-get install -y libpng-dev libonig-dev libxml2-dev zip unzip git curl

# Instalamos extensiones de PHP fundamentales para el ERP de CAPSUR
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# 3. Al final el composer install
RUN composer install --no-dev --optimize-autoloader
EXPOSE 80
