# studio - backend

#### 1. Clone  
`git clone git@gitlab.ateriad.ir:studio/backend.git` 

#### 2. Navigate  
`cd backend`

#### 3. Environment
`cp .env.example .env` 

`cp laravel/.env.example laravel/.env` 

- fill in the blanks(<sub><sup>NGINX_EXPOSED_PORT, DB_EXPOSED_PORT, ...</sup></sub>)

#### 4. Build
`docker-compose build`  

#### 5. Start
`docker-compose up -d`

#### 6. Dependencies and Migrations
`docker-compose exec node npm install --prefix nodejs`

`docker-compose exec php composer install`

`docker-compose exec php php artisan key:generate`

`docker-compose exec php php artisan migrate:refresh --seed`

`docker-compose exec php php artisan storage:link`

#### 7. Permissions

`sudo chmod -R 0777 laravel/storage`

`sudo chmod -R 0777 laravel/bootstrap/cache`

#### 8. Launch

Enter on [http://localhost:<sub><sup>NGINX_EXPOSED_PORT</sup></sub>](http://localhost:8080)
