APP_NAME = battleship-player

start:
	docker-compose -f docker-compose.yml -f docker-compose-dev.yml --project-name $(APP_NAME) up -d --build
	docker-compose --project-name $(APP_NAME) exec -T --user www-data api-player_php-fpm sh -c "composer install"
	docker-compose --project-name $(APP_NAME) exec -T --user www-data api-player_php-fpm sh -c "bin/console doctrine:schema:update --force"

