# SISACAD
## Installation
1) Install [Docker](https://docs.docker.com/engine/install/ubuntu/#install-using-the-repository)
   > If requires permissions, use `sudo usermod -aG docker $USER` and restart.
2) Initialize Laravel environment
```shell
composer install \
cp .env.example .env \
php artisan key:generate
```
3) Initialize Sail with Postgres
```shell
docker context use default \
composer require laravel/sail --dev \
php artisan sail:install --with=pgsql \
./vendor/bin/sail npm install
```
4) Creating `storage` folders
```shell
mkdir -p ./storage/framework/sessions \
mkdir -p ./storage/framework/views \
mkdir -p ./storage/framework/cache
```

### Update Database
```shell
./vendor/bin/sail artisan migrate:fresh --seed
```

### Running
```shell
./vendor/bin/sail up -d       # Iniciar backend
./vendor/bin/sail npm run dev # Iniciar frontend
```
