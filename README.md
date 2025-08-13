## Stack

-   MySQL.
-   Php Laravel.
-   Nginx.
-   JWT for authemtication
-   Docker

This is a Service-Action Pattern , with Modularized routing system,

## Setup (API)

Clone the project from github. Ensure LAMP/MAMP Server is set on your machine

-   Run `composer install`
-   within your project directory, run `cp .env.example .env` Set your database credentials in .env
-   Run `php artisan migrate`
-   Run `php artisan db:seed`
-   Run `php artisan jwt:secret`
-   Login with this default login credentials : `"email": "eleanor.armstrong@appveam.co",
"password": "password"`

## Route

-   Login Route POST `auth/login`
-   Payment Route
    `/payment/create`

-   Payment Status Change PATCH
    `/payment/{{payment}}/status` where {payment} is the payement ID and "status" as body parameter to be either succeeded, failed, or refunded, pending or disputed
-   Broacast
    `broadcasting/auth` use the the channel-name ("channel_name": "customer.{customerId}") as request body parameter

## Reverb without Docker

-   Run `php artisan reverb:start --port=6001 --debug`

-   Listen to Queue ; `php artisan queue:listen`

Test (Feature Test)
Ensure SQLite is install on your machine or Server.

-   php artisan test --filter=PaymentStatusChangedTest

## Docker setup

Ensure Docker runs on your system
Run `docker compose up -d` to start all services
