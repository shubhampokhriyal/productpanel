# Admin Panel

Admin panel for CRUD operation of products

## Installation

Use the package manager [composer](https://getcomposer.org/download/) to install the php dependencies.

```bash
composer install
```
Use the package manager npm to install the vue js dependencies.

```bash
npm install
```
copy .env.example to .env and generate the application key

```bash
cp .env.example .env
```
```bash
php artisan key:generate
```
config the db in .env file and run migration command to get tables.

```bash
php artisan migrate
```
create a storage link
```bash
php artisan storage:link
```
Start the server and access the link
```bash
php artisan serve
```
`Go to registration page and get registered to login the panel`

```To use the forget password feature, simply configure the smtp host with other required details in .env file```