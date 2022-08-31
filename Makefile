install:
	composer install
	cp .env.example .env

docker-up:
	docker-compose -f ./docker/docker-compose.yml --env-file ./.env up -d

docker-down:
	docker-compose -f ./docker/docker-compose.yml --env-file ./.env down

docker-build:
	docker-compose -f ./docker/docker-compose.yml --env-file ./.env build