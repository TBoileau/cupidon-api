.PHONY: install build analyse

install:
	composer install --no-progress --prefer-dist --optimize-autoloader

composer:
	composer valid

phpstan:
	php vendor/bin/phpstan analyse -c phpstan.neon src --no-progress

analyse:
	make composer
	make phpstan
