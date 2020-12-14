## Pre Requisite

- php interpreter
- composer can be found [here](https://getcomposer.org/download/)

## Setting up

### Clone the Repo

`git clone git@github.com:pranaypatro/gocomet-assignment.git`

- `composer install`
- `chmod -R 777 storage bootstrap/cache`
- `cp .env.example .env`
- `php artisan key:generate`

### Database Setup

Create a MySQL Database and use the credentials, database name in .env file

### Run Application

`composer install`
`php artisan serve`


### Access The Application 

http://127.0.0.1:8000
