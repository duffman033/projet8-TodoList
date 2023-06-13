##@ Docker

init: ## Initialize docker environment
	@echo "Initializing docker environment..."
	@docker-compose up -d --build

.PHONY: init