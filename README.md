# Tesis

*All functionalities*

| FEATURES | STATUS | UNITE TEST | FEATURE TEST | APLICATION TEST | DESIGN |
| :--- | :---: | :---: | :---: | :---: | :---: |
| Auth | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark: |
| Website | :heavy_check_mark: | :x: | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark: |
| Article | :heavy_check_mark: | :x: | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark: |
| Search | :heavy_check_mark: | :x: | :x: | :x: | :heavy_check_mark: |
| Chat | :x: | :x: | :x: | :x: | :x: |
| Notifications | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark: | :x: | :heavy_check_mark: |
| Client panel | :heavy_check_mark: | :x: | :heavy_check_mark: | :x: | :heavy_check_mark: |
| Admin panel | :heavy_check_mark: | :x: | :heavy_check_mark: | :x: | :heavy_check_mark: |

## Instalación

 - Clonar el repositorio.
 - Ejecutar comando **composer install** (para instalar la misma versión).
 - Si tienes algun error buscar en [google](https://www.google.com/) para darle solucion (Se utilizan librerias que es posible no puedas instalar en **XAMPP**  o **WAMP**).
 - Ejecutar la migraciones: **php artisan migration**.
 - (opcional) : 
	 - Para ejecutar los test es recomendable crear una base de datos dedicada para ello ve abre (el archivo de entorno) .env debes indicar el nombre de la base de datos en **DB_DATABASE_TEST**.
	 - Para poder utilizar el login con redes social debes crear un cliente **Oauth** en dichos sitios.
	 - Para ver las imágenes guardas en el sistema utilizar el comando: **php artisan storage:link**.
	 - Todos los procesos pesados son procesados en colas como **email, notificaciones, conversion y subida de imagenes** debes utilizar **php artisan queue:listen** o algun servicio que maneje las colas de trabajo.

## Imágenes
![enter image description here](https://image.ibb.co/iuboGJ/image.png)

![enter image description here](https://image.ibb.co/fqab3y/image.png)

![enter image description here](https://image.ibb.co/d6sOiy/image.png)

![enter image description here](https://image.ibb.co/hkP8GJ/image.png)

![enter image description here](https://image.ibb.co/nKaLVd/image.png)

![enter image description here](https://image.ibb.co/jwj3iy/image.png)