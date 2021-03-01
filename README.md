# Trufla Code Challenge - Laravel PHP Framework (8.12)

## Usage:
- Create DB with name **trufla** (Terminal, PHPmyAdmin, or any tool supporting MySQL) 

<b><i>you may need to configure .env.example file to your local environment</i></b>

- Run on Command Widnow (Terminal) <small><i>This command runs a script which runs "composer install" if not tunned before, copies .env.example file to .env and runs "php artisan key:generate", then migrates the database and runs local server "php artisan serve". 

        bash run.sh     


    or


        sh run.sh       


    or 

        . run.sh        

- Once firing the command the service will be ready for use on: .

    localhost:8000

## List of features
-   Run the following command to seed movies in database without schedule

        php artisan movies:seed {num_of_records}    

-   Run the following command to start the seeder schedule <b>(Before this step open the package service provider at path: <i>packages/Reda/MoviesSeeder\Providers\MoviesSeederServiceProvider</i> line (32) you may configure the interval this schedule runs.)</b>

        php artisan schedule:run

## API endpoint
Method |   URI    |   Headers
-------------    |   ------------   |   ------------
GET |  api/movies   |  Content-Type

## API Endpoint Filtering scopes
Parameter Name    |   Expected Values | Example
------------   |   ------------   |   ------------
category_id   |  Any Integer number   |   ?category_id=9
popular     |  DESC OR ASC   |   ?popular=ASC
rated     |  DESC OR ASC   |   ?rated=DESC
