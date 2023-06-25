# Mortgage loan calculator web application

## Installation

1- Clone the repository

    git clone https://github.com/ali-maihoob/mortgage-loan.git

2- Switch to the repo folder

    cd mortgage-loan

3- Init env File:
On Windows:

    copy .env.example .env
On Linux:

    cp .env.example .env

4- Install all the dependencies using composer

    composer install

## Database Configuration
1- create new database called: mortgage


The default database username is "root" and password is empty so if you want to change them, you can update .env file

2- Database Migration

    php artisan migrate

3- Database Seeder

    php artisan db:seed

4- Default credentials

    ali@test.com
    123456
