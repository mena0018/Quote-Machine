PHP = $(EXEC) php
COMPOSER = $(EXEC) composer
NPM = $(EXEC) npm
SYMFONY_CONSOLE = $(PHP) bin/console


## —— 🔥 App ——
init: ## Init the project 
	$(MAKE) composer-install
	

## —— 🎻 Composer ——
composer-install: ## Install the dependencies
	$(COMPOSER) install

composer-update: ## Update the dependencies
	$(COMPOSER) update


## —— 🎉 NPM ——
npm-install: ## Install all npm dependencies
	$(NPM) install
	
npm-update: ## Update all npm dependencies
	$(NPM) update


## —— 📊 Database ——
database-init: ## Init database
	$(MAKE) database-drop
	$(MAKE) database-create
	$(MAKE) database-migration
	$(MAKE) database-migrate
	$(MAKE) database-fixtures-load

database-drop: ## Drop database
	$(SYMFONY_CONSOLE) doctrine:database:drop --force --if-exists

database-create: ## Create database
	$(SYMFONY_CONSOLE) doctrine:database:create --if-not-exists

database-migration: ## Make migration
	$(SYMFONY_CONSOLE) make:migration

database-migrate: ## Send migration
	$(SYMFONY_CONSOLE) doctrine:migrations:migrate

database-fixtures-load: ## Load fixtures
	$(SYMFONY_CONSOLE) doctrine:fixtures:load


## —— ✅ Test ——
databse-test-init: ## Init database for tests
	$(SYMFONY_CONSOLE) doctrine:database:drop --force --if-exists --env=test
	$(SYMFONY_CONSOLE) doctrine:database:create --if-not-exists --env=test
	$(SYMFONY_CONSOLE) doctrine:migrations:migrate --env=test
	$(SYMFONY_CONSOLE) doctrine:fixtures:load --env=test

test: ## Run tests
	$(MAKE) databse-test-init
	$(PHP) bin/phpunit --testdox tests/Unit/
	$(PHP) bin/phpunit --testdox tests/Functional/

unit-test: ## Run unit tests
	$(MAKE) database-init-test
	$(PHP) bin/phpunit --testdox tests/Unit/

functional-test: ## Run functional tests
	$(MAKE) database-init-test
	$(PHP) bin/phpunit --testdox tests/Functional/


## —— 💨 Cache ——
cache-clear: ## Clear the cache
	$(SYMFONY_CONSOLE) cache:clear

## —— 💨 PHP-CS-FIXER ——
fixer: ## Php-cs-fixer with GrumPHP
	$(PHP) ./vendor/bin/grumphp run


help: ## List of commands
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'