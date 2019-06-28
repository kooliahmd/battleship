APP_NAME = battleship-gameserver

start:
	docker-compose -f docker-compose.yml -f docker-compose-dev.yml --project-name $(APP_NAME)  stop
	docker-compose -f docker-compose.yml -f docker-compose-dev.yml --project-name $(APP_NAME) up -d --build

