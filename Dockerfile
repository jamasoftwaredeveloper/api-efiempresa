# Usar una imagen base de PHP
FROM php:8.2-fpm

# Instalar dependencias del sistema y extensiones de PHP necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libpq-dev \
    unzip \
    curl \
    gnupg2 \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql pdo_pgsql

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Instalar Composer (debería estar al final de la instalación de dependencias)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar los archivos de la aplicación al contenedor
COPY . .

# Instalar las dependencias de PHP usando Composer
RUN composer install --no-scripts --no-autoloader && \
    composer dump-autoload

# Copiar el script de entrada y hacerlo ejecutable
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Exponer el puerto que usarás (usualmente 8000 para desarrollo)
EXPOSE 8000

# Configurar el script de entrada
ENTRYPOINT ["/usr/local/bin/start.sh"]
