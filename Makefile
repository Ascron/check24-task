define setup_env
	$(eval ENV_FILE := .env)
	$(eval include .env)
	$(eval export sed 's/=.*//' .env)
endef

install:
	composer install
	cp .env.example .env

install-db:
	$(call setup_env)
	docker exec -i check24_mysql_1 mysql -u $(MYSQL_USER) -p$(MYSQL_PASSWORD) --database $(MYSQL_DATABASE) < database/database.sql

docker-up:
	docker-compose -f ./docker/docker-compose.yml --env-file ./.env up -d

docker-down:
	docker-compose -f ./docker/docker-compose.yml --env-file ./.env down

docker-build:
	docker-compose -f ./docker/docker-compose.yml --env-file ./.env build