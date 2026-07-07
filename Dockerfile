# Base image PHP 8.2 avec FPM
FROM php:8.2-fpm

# Installation des dépendances système et extensions PHP requises par Laravel
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définition du répertoire de travail
WORKDIR /var/www

# Copie de tous les fichiers du projet
COPY . .

# Installation des dépendances Laravel et correction des permissions
RUN composer install --optimize-autoloader --no-dev \
    && chown -R www-data:www-data storage bootstrap/cache

# Configuration de Nginx (écoute sur le port 8080, standard pour Railway)
RUN echo "server { \
    listen 8080; \
    root /var/www/public; \
    index index.php; \
    location / { \
        try_files \$uri \$uri/ /index.php?\$query_string; \
    } \
    location ~ \.php$ { \
        fastcgi_pass 127.0.0.1:9000; \
        fastcgi_index index.php; \
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name; \
        include fastcgi_params; \
    } \
}" > /etc/nginx/sites-available/default

# Exposition du port 8080
EXPOSE 8080

# Commande pour démarrer PHP-FPM et Nginx au lancement du conteneur
CMD service php8.2-fpm start && nginx -g "daemon off;"