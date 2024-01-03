# Especificar la imagen base
FROM php:8.2-apache

# Instalar libzip-dev y otros paquetes necesarios
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    curl \
&& rm -rf /var/lib/apt/lists/*

# Instalar extensiones PDO, PDO MySQL y ZIP
RUN docker-php-ext-install pdo pdo_mysql \
&& docker-php-ext-configure zip \
&& docker-php-ext-install zip

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar la configuración personalizada de php.ini
COPY ./config/php.ini /usr/local/etc/php/php.ini

# Ejecutar Apache en el fondo al iniciar el contenedor
CMD ["apache2-foreground"]
