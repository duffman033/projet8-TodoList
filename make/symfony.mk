##@ Symfony

install: db-create fixtures-load
	@echo "Installing dependencies"
	@composer install

db-create:
	@echo "Creating the database"
	@php bin/console doctrine:database:create --if-not-exists
	@php bin/console doctrine:schema:create

db-reset: reset db-create

reset:
	@echo "Resetting the database"
	@php bin/console doctrine:database:drop --force

fixtures-load:
	@echo "Loading fixtures"
	@php bin/console doctrine:fixtures:load --no-interaction

serve:
	@echo "Starting the server"
	@symfony server:start

.PHONY: install db-create fixtures-load serve