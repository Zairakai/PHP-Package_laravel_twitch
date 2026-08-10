# Zairakai Laravel Dev Tools - Project Makefile
# This file includes shared targets from vendor/zairakai/laravel-dev-tools

.DEFAULT_GOAL := help

# Include shared tooling from Zairakai Laravel Dev Tools
include vendor/zairakai/laravel-dev-tools/tools/make/core.mk

# Override Docker container name if needed (default: app)
# ZAIRAKAI_DOCKER_APP := my-app-container

# Override Pint command if needed (e.g., for custom Docker setup)
# CMD_PINT := docker exec my-app vendor/bin/pint

# Override PHPStan command if needed
# CMD_PHPSTAN := docker exec my-app vendor/bin/phpstan

# Add your custom project-specific targets below

## —— 📚 Documentation ——

PHPDOC_VERSION := v3.10.0
PHPDOC_PHAR := build/phpDocumentor.phar

$(PHPDOC_PHAR):
	@mkdir -p build
	@echo "Downloading phpDocumentor $(PHPDOC_VERSION)…"
	@curl -sL "https://github.com/phpDocumentor/phpDocumentor/releases/download/$(PHPDOC_VERSION)/phpDocumentor.phar" -o $(PHPDOC_PHAR)
	@chmod +x $(PHPDOC_PHAR)

.PHONY: docs
docs: $(PHPDOC_PHAR) ## Generate API documentation (phpDocumentor) into build/docs
	@php $(PHPDOC_PHAR) run -c phpdoc.dist.xml
	@echo "Documentation generated at build/docs/index.html"

.PHONY: doc
doc: docs
