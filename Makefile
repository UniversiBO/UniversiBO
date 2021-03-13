.PHONY: composer
composer:
	docker-compose exec web composer $(args)

.PHONY: composer-install
composer-install:
	docker-compose exec web composer install
