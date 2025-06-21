DOCKER_COMPOSE := docker-compose

up:
	sudo ${DOCKER_COMPOSE} up --build

start:
	${DOCKER_COMPOSE} start

stop:
	${DOCKER_COMPOSE} stop

down:
	${DOCKER_COMPOSE} down

restart: stop start

rebuild: down build up