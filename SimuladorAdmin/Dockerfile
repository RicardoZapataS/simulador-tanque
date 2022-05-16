# Partimos de la imagen php en su versión 7.4
FROM php:7.4-fpm
LABEL stage=builder

# Copiamos los archivos package.json composer.json y composer-lock.json a /var/www/
COPY composer*.json /var/www/

# Nos movemos a /var/www/
WORKDIR /var/www/

# Instalamos las dependencias necesarias
RUN apt-get update && apt-get install -y \
    build-essential \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    git \
    curl

# Instalamos extensiones de PHP
RUN docker-php-ext-install pdo_mysql zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

# Instalamos composer
RUN curl -o composer.php https://getcomposer.org/installer
RUN php composer.php --install-dir=/usr/local/bin --filename=composer

# Copiamos todos los archivos de la carpeta actual de nuestra 
# computadora (los archivos de laravel) a /var/www/
COPY . /var/www/
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www/storage

# Exponemos el puerto 9000 a la network
EXPOSE 8000

# Corremos el comando php-fpm para ejecutar PHP
CMD ["php-fpm"]
