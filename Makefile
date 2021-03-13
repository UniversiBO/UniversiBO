.PHONY: get-ready
get-ready: | reload composer-install

.PHONY: build
build:
	docker-compose build

.PHONY: up
up:
	docker-compose up --build -d

.PHONY: down
down:
	docker-compose down --remove-orphans

.PHONY: reload
reload: | down up

.PHONY: bash
bash:
	docker-compose exec web bash

.PHONY: interactive
interactive:
	docker-compose exec web php -a

.PHONY: console
console:
	docker-compose exec web bin/console $(args)

.PHONY: composer
composer:
	docker-compose exec web composer $(args)

.PHONY: composer-install
composer-install:
	docker-compose exec web composer install

.PHONY: init-db
init-db:
	docker-compose exec db /bin/bash /sql/sql.sh
