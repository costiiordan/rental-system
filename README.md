# Bike Rental System

## Install project
This is a Laravel project dockerized. You can find more examples of dockerized Laravel projects here:
https://github.com/dockersamples/laravel-docker-examples

### Installation steps

```bash
docker compose -f compose.dev.yaml up -d
docker compose -f compose.dev.yaml exec workspace bash
composer install
npm install
npm run dev
php artisan migrate
```
Open http://localhost in your browser.

### Common commands
Start containers:
```bash
docker compose -f compose.dev.yaml start
```
Stop containers:
```bash
docker compose -f compose.dev.yaml stop
```
Open workspace container bash:
```bash
docker compose -f compose.dev.yaml exec workspace bash
```
Rebuild containers:
```bash
docker compose -f compose.dev.yaml up -d --build
```
Export translations:
```bash
php artisan translatable:export en
```
