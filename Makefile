.PHONY: install build analyse phpstan phpinsights phpcpd phpmd tests

profile:
	blackfire-player run .blackfire.yaml --endpoint=$(endpoint)

install:
	cp .env.dist .env.$(env).local
	sed -i -e 's/DATABASE_USER/$(db_user)/' .env.$(env).local
	sed -i -e 's/DATABASE_PASSWORD/$(db_password)/' .env.$(env).local
	composer install
	make prepare env=$(env)
	php bin/console lexik:jwt:generate-keypair

composer:
	composer valid

phpstan:
	php vendor/bin/phpstan analyse -c phpstan.neon src --no-progress

phpinsights:
	vendor/bin/phpinsights --no-interaction

phpcpd:
	vendor/bin/phpcpd src/

phpmd:
	vendor/bin/phpmd src/ text .phpmd.xml

database:
	php bin/console doctrine:database:drop --if-exists --force --env=$(env)
	php bin/console doctrine:database:create --env=$(env)
	php bin/console doctrine:schema:update --force --env=$(env)

fixtures:
	php bin/console doctrine:fixtures:load -n --env=$(env)

prepare:
	make database env=$(env)
	make fixtures env=$(env)

analyse:
	make composer
	make phpcpd
	make phpmd
	make phpinsights
	make phpstan

tests:
	php bin/phpunit --testdox

fix:
	vendor/bin/php-cs-fixer fix

deploy:
	composer install
	make prepare env=$(env)
