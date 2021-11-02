.PHONY: install build analyse

install:
	composer install --no-progress --prefer-dist --optimize-autoloader

composer:
	composer valid

phpstan:
	php vendor/bin/phpstan analyse -c phpstan.neon src --no-progress

phpinsights:
	vendor/bin/phpinsights --no-interaction

analyse:
	make composer
	make phpinsights
	make phpstan
