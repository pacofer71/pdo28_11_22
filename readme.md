# Crud PHP PDO, Composer, Bootstrap, Dotenv, Sweetalert2, Faker
## _Ejemplo de un CRUD en PHP (DAW IES Al-ANDALUS)_


[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://travis-ci.org/joemccann/dillinger)

Utilizaremos Faker para generarnos datos de prueba, sweetalert2 para la info y dotenv para guardar configuraciones en .env

- Iniciamos composer
- Utilizaremos el paquete: [vlucas/phpdotenv]: <https://packagist.org/packages/vlucas/phpdotenv> para no mostrar configuración.
- Utilizaremos el paquete: [fakerphp/faker]: <https://packagist.org/packages/fakerphp/faker> para cargar configuraciones de .env.
- Utilizaremos: [sweetalert2]: <https://sweetalert2.github.io/> para las alertas
- ✨Magic ✨

## Install

- gitclone del repositorio
- composer update para traer las librerias necesarias
- Renombrar env.example a .env
- Poner en el archivo .env nuestra configuración de mysql/mariadb
```sh
git clone https://github.com/pacofer71/pdo28_11_22
composer update
```