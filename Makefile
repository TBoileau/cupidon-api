.PHONY: install build analyse phpstan phpinsights phpcpd phpmd

install:
	composer install --no-progress --prefer-dist --optimize-autoloader

composer:
	composer valid
	vendor/bin/patrol

phpstan:
	php vendor/bin/phpstan analyse -c phpstan.neon src --no-progress

phpinsights:
	vendor/bin/phpinsights --no-interaction

phpcpd:
	vendor/bin/phpcpd src/

phpmd:
	vendor/bin/phpmd src/ text .phpmd.xml

analyse:
	make composer
	make phpcpd
	make phpmd
	make phpinsights
	make phpstan
