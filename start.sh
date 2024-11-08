#!/bin/bash

# Limpiar cachés y generar autoload optimizado
php artisan optimize:clear
php artisan config:cache
php artisan cache:clear

# Generar la clave de aplicación
php artisan key:generate

# Esperar unos segundos antes de las migraciones
sleep 10

# Ejecutar migraciones y seed si no se ha hecho previamente
if [ ! -f /var/www/html/.migrated ]; then
    php artisan migrate:refresh --force
    php artisan db:seed --force
    touch /var/www/html/.migrated  # Crear un archivo de marcador
fi

# Iniciar el servidor de Laravel
echo "Iniciando el servidor de Laravel..."
php artisan serve --host=0.0.0.0 --port=8000
