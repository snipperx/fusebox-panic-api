# Laravel Api  Tests - Step by Step
Pratical step-by-step how to build auth tests in a RESTful API made in Laravel 5.5

### Prerequisites
* Apache
* PHP
* Composer
* [Laravel new app created](https://github.com/cantellir/laravel-new-app)
* [Laravel api auth with passport done](https://github.com/cantellir/laravel-api-auth)

### Initial notes
The project in this repo contains all the steps finalized

Configure database

In terminal run

```
composer update
```
```
php artisan make:refesh seeder
```
```
php artisan passport:install
```

```
php artisan serve
```

### Configure email settings in the env
In the root dir of the project adjust phpunit.xml adding DB_CONNECTION
```
   In the env 
   
THIRD_PARTY_API_BASE_URL=https://wayne.fusebox-staging.co.za/api/v1

THIRD_PARTY_API_KEY=eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMDY3YWExNzg2OGQxZmY3NDEyYmY3YTc5YTViOGI1ODhkZTc3ZmUzMjRmM2ZjNGMwZjdlZjQ1YWZjOGRmYTc0ODJmYzZkOGQzOWU0ODAzMGEiLCJpYXQiOjE3MDQ5Njc3MDAsIm5iZiI6MTcwNDk2NzcwMCwiZXhwIjoxNzM2NTkwMTAwLCJzdWIiOiIxNCIsInNjb3BlcyI6W119.I1xbZxCoXTiqszo-Z6mYKTapqydDzTbq169INk46AWpMn_rfIzH3cnYFOhD96ZP8nBnCNVo9P3f3svVjDh953PCcphwE9tytiNQJTMGD_Gf7sVejHZ-xsHPJsnNU24dDhiRn7lZEto_xToi1flic4Syi9lcnD14eIDQ8zWn_xXB-JS2nf_KG7FjOUEQI9mUYDPNxj9gy6E0W6Sb3drlQltwy6idTJWQ-6V-1IEMWjRuV6NnejrEGcBzz6Iip2-8LYVNhadZ9Dgyn4Js2Si0SBCmMA-gWNGPRQTK7G9XmrHbVYV6aU_qG9RKcAyVdsk7vpyxHLcAs4sajpAr-zw3vcGELyH8YIZJ0I-9CBO4kvAirHBIhnodbW09tEjbsLp_iE2kle7uoZlLBCxjnVwXhTCwLJ0Zh9LXSFtD80a47wXD8Q1ofnTcAzIXr31llOTU3LMkmODfFeEpAfN-aY3m9ZoGPWstovLSCor9vWdsDfQs5YkIhOI7MCoL8HxHF1o2ENZrGM1dpKNU8SJlX4yWUT-QA50PU4VjntCogFwnfzdmVb5n8X9Y-KJ2x_Y6Z4yRL7egduovpQ9pf2ZYPHook9zUZ2Prk9n1599ZkpfkzI7EsGndoTvXZfJXpGgFXztv7VNo2P0W45pl-6Q5QeBqAtbSKBHZ2J8nftMNKPEEZ12I

configure you enviroment variable in this order
```

### Serve your application

```
http://127.0.0.1:8000/api/documentation#/
```

```
User email is  - Commissioner Gordon
Password - 12345
```

## References
* [Laravel docs](https://laravel.com/docs/5.5) - Laravel Documentation
* [Laravel Passport Post](https://laravelcode.com/post/laravel-passport-create-rest-api-with-authentication) - Create REST API with authentication
* [Laravel API Tutorial](https://www.toptal.com/laravel/restful-laravel-api-tutorial) - How to Build and Test a RESTful API

