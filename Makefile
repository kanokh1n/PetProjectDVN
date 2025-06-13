DOCKER_COMPOSE := docker-compose
BACKEND := backend-1
FRONTEND := frontend

build:
	${DOCKER_COMPOSE} build

start:
	${DOCKER_COMPOSE} start

stop:
	${DOCKER_COMPOSE} stop

up:
	${DOCKER_COMPOSE} up -d --remove-orphans

down:
	${DOCKER_COMPOSE} down

restart: stop start

rebuild: down build up

backend:
	${DOCKER_COMPOSE} exec ${BACKEND} /bin/bash

frontend:
	${DOCKER_COMPOSE} exec ${FRONTEND} /bin/bash