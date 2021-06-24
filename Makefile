start:
	php artisan serve --host 127.0.0.1

lint:
	composer run-script phpcs -- --standard=PSR12 app

fix:
	composer run-script phpcbf -- app

install:
	composer install

start-db:
	sudo service postgresql start

check-db:
	ps aux | grep postgres

migrate:
	php artisan migrate

console:
	php artisan tinker

deploy:
	git push heroku








setup:
	composer install
	cp -n .env.example .env|| true
	php artisan key:gen --ansi
	touch database/database.sqlite
	php artisan migrate
	php artisan db:seed
	npm install

watch:
	npm run watch

log:
	tail -f storage/logs/laravel.log

test:
	php artisan test

compose:
	docker-compose up

compose-test:
	docker-compose run web make test

compose-bash:
	docker-compose run web bash

compose-setup: compose-build
	docker-compose run web make setup

compose-build:
	docker-compose build

compose-db:
	docker-compose exec db psql -U postgres

compose-down:
	docker-compose down -v