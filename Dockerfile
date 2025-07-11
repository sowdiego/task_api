FROM php:8.2-cli

# Installer extensions requises
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    libpq-dev \
    zip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_pgsql zip

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copier tous les fichiers
COPY . .

# Installer les dépendances Laravel
RUN composer install --optimize-autoloader --no-dev

# Démarrer Laravel
CMD php artisan serve --host=0.0.0.0 --port=10000
