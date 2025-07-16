PHP_CONTAINER = $(shell docker-compose ps -q php)
SYMFONY = docker exec -it $(PHP_CONTAINER) php bin/console

up:
	docker-compose up -d --build

down:
	docker-compose down

restart:
	docker-compose down && docker-compose up -d --build

install:
	docker exec -it $(PHP_CONTAINER) composer install

create-project:
	docker exec -it $(PHP_CONTAINER) bash -c "cd /var/www/html && composer create-project symfony/website-skeleton ."

cc:
	$(SYMFONY) cache:clear

migrate:
	$(SYMFONY) doctrine:migrations:migrate --no-interaction

schema-update:
	$(SYMFONY) doctrine:schema:update --force

fixtures:
	$(SYMFONY) doctrine:fixtures:load --no-interaction

logs:
	docker-compose logs -f

xdebug-on:
	docker exec -it $(PHP_CONTAINER) bash -c "echo 'xdebug.mode=debug' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && kill -USR2 1"

xdebug-off:
	docker exec -it $(PHP_CONTAINER) bash -c "sed -i '/xdebug.mode/d' /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && kill -USR2 1"

test:
	docker exec -it $(PHP_CONTAINER) ./vendor/bin/phpunit

bash:
	docker exec -it $(PHP_CONTAINER) bash

# Commandes utiles
make up               # Lancer Docker
make down             # Stopper les containers
make create-project   # Créer le projet Symfony (1ère fois)
make install          # Installer les dépendances PHP
make migrate          # Lancer les migrations
make fixtures         # Charger les fixtures
make xdebug-on        # Activer Xdebug
make xdebug-off       # Désactiver Xdebug
make bash             # Entrer dans le conteneur PHP
