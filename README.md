# Información de proyecto

Este proyecto consiste en una API RESTful desarrollada con Laravel 10 para gestionar usuarios, productos y ventas. Permite la creación de usuarios mediante un endpoint de registro que valida los datos recibidos y los almacena en la base de datos. Además, los administradores pueden realizar operaciones CRUD sobre productos y ventas, permitiendo crear, leer, actualizar y eliminar estos registros.

La autenticación de usuarios se gestiona utilizando auth, una solución ligera que requiere un token de autenticación en la versión 2 de la API, mientras que la versión 1 no requiere autenticación. La API está diseñada sin la necesidad de formularios, ya que el registro de usuarios se realiza a través de un endpoint que valida y almacena los datos directamente.

Entre las principales características del proyecto se incluyen:

Validaciones Request de Laravel para garantizar que los datos sean correctos antes de procesarlos.
Uso de Resource para estructurar las respuestas de manera consistente.
Tests automatizados para asegurar la calidad del código.
Docker para facilitar el entorno de desarrollo y despliegue.
Documentación de la API con Swagger para ofrecer una interfaz interactiva y detallada.
Implementación del Patrón Repositorio para separar la lógica de acceso a datos.
Seeders y Factories para generar datos de prueba fácilmente.
Rutas API definidas bajo el patrón RESTful.
Uso de Traits para compartir funcionalidades entre modelos o controladores.
Migraciones para gestionar la estructura de la base de datos de manera ordenada.
Este enfoque asegura que la aplicación sea fácil de mantener, escalable y segura, aprovechando las mejores prácticas de desarrollo en Laravel. También cuenta con ejemplos básicos de uso de job, queue
Este proyecto consiste en una API RESTful desarrollada con Laravel 10 para gestionar usuarios, productos y ventas. Permite la creación de usuarios mediante un endpoint de registro que valida los datos recibidos y los almacena en la base de datos. Además, los administradores pueden realizar operaciones CRUD sobre productos y ventas, permitiendo crear, leer, actualizar y eliminar estos registros. La autenticación de usuarios se gestiona utilizando auth , una solución ligera que requiere un token de autenticación en la versión 2 de la API, mientras que la versión 1 no requiere autenticación. La API está diseñada sin la necesidad de formularios, ya que el registro de usuarios se realiza a través de un endpoint que valida y almacena los datos directamente. Entre las principales características del proyecto se incluyen: Validaciones Request de Laravel para garantizar que los datos sean correctos antes de procesarlos. Uso de Resource para estructurar las respuestas de manera consistente. Tests automatizados para asegurar la calidad del código. Docker para facilitar el entorno de desarrollo y despliegue. Documentación de la API con Swagger para ofrecer una interfaz interactiva y detallada. Implementación del Patrón Repositorio para separar la lógica de acceso a datos. Seeders y Factories para generar datos de prueba fácilmente. Rutas API definidas bajo el patrón RESTful. Uso de Traits para compartir funcionalidades entre modelos o controladores. Migraciones para gestionar la estructura de la base de datos de manera ordenada. Este enfoque asegura que la aplicación sea fácil de mantener, escalable y segura, aprovechando las mejores prácticas de desarrollo en Laravel. También cuenta con ejemplos básicos de uso de job, queue
Aptitudes: Laravel · laravel Sanctum · Migración de datos · Seeders · Factory · Swagger UI

Se adicciono pago con epayco y permisos, roles, base datos con sqlite, hay una base datos ya creada, solo toca configurar la ruta en el archivo .env

![image](https://github.com/user-attachments/assets/127419c9-7795-45e9-94aa-da6701ae136f)
Configurar epayco en el archivo .env

![image](https://github.com/user-attachments/assets/66235463-eef6-4dd2-ad08-b05c84ec4648)


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
