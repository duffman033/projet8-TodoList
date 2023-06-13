##@ Testing
test: ## Run tests
	@php bin/console doctrine\:fixtures\:load --env=test --no-interaction
	@vendor/bin/phpunit -d memory_limit=-1

test-%: ## Run tests for a specific file
	@php bin/console doctrine\:fixtures\:load --env=test --no-interaction
	@vendor/bin/phpunit -d memory_limit=-1 --filter $*

test-coverage: ## Run tests with coverage
	@php bin/console doctrine\:fixtures\:load --env=test --no-interaction
	@XDEBUG_MODE=coverage vendor/bin/phpunit -d memory_limit=-1  --coverage-html tests/coverage

.PHONY: test