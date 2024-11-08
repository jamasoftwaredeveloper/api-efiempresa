# api-efiempresa

Tener en cuenta la versión de php >=8.1, 
Contar con composer.
Ingresar al proyecto y abrir consola, ejecutar:
1. composer install, (el proyecto va con la carpeta vendor, puede que no sea necesario, sino eliminar y darle el comando mencionado anteriormente)
Recordar, configurar el archivo .env,
Ejecutar los comandos:
1. php artisan key:generate
2. php artisan migrate --seed, para crear las migraciones y los datos semilla.
3. php artisan serve.

.................................................DOCKER............................................
Instalar docker.
Abrir docker.
Ejecutar
docker-compose up --build  ó docker-compose up -d --build

Nota: Revisar la raiz del proyecto, si existe el archivo .migrated, eliminarlo, si nos haz ejecutado el comando docker.
