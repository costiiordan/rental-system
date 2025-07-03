# Bike rental system

## Docker setup

https://github.com/dockersamples/laravel-docker-examples

## Docker compose

```bash
docker compose -f compose.dev.yaml exec workspace bash
composer install
npm install
npm run dev
```

```bash
docker compose -f compose.dev.yaml exec workspace php artisan migrate
```

```bash
docker compose -f compose.dev.yaml exec workspace bash
```

```bash
docker compose -f compose.dev.yaml exec workspace php artisan migrate
```

```bash
docker compose -f compose.dev.yaml up -d --build
```

```bash
docker compose -f compose.dev.yaml down
```


