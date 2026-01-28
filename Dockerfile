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

# Extensiones PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Copiar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /var/www/html

# Copiar proyecto
COPY . .

# Permisos
RUN chown -R www-data:www-data storage bootstrap/cache

# Instalar dependencias Laravel
RUN composer install --no-dev --optimize-autoloader

# Puerto
EXPOSE 80
