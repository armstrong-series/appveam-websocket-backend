## Stack

-   MySQL.
-   Php Laravel.
-   Nginx.
-   JWT for authemtication

This is a Service-Action Pattern , with Modularized routing system,

## Setup

Clone the project from github. Ensure LAMP/MAMP Server is set on your machine

-   Run `composer install`
-   within your project directory, run cp .env.example .env. Set your database credentials in .env
-   Run ` php artisan migrate`
-   Run `php artisan db:seed`
-   Run `php artisan jwt:secret`
-   Login with this default login credentials : `"email": "eleanor.armstrong@appveam.co",
"password": "password"`

## Route

-   Login Route POST `auth/login`
-   Payment Route
    `/payment/create`

-   Payment Status Change
    `/payment/{{payment}}/status` where {payment} is the payement ID

Test (Feature Test)

-   php artisan test --filter=PaymentStatusChangedTest
