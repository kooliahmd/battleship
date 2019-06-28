APP_NAME = bundle-api

start:
	docker-compose -f docker-compose.yml -f docker-compose-dev.yml --project-name $(APP_NAME) up -d --build
	docker-compose --project-name $(APP_NAME) exec --user www-data php-fpm sh -c "composer install"

