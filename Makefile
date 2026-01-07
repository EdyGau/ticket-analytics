.PHONY: setup tests quality help

help:
	@echo "Available commands:"
	@echo "  make setup     - Install dependencies, update schema and clear cache"
	@echo "  make tests     - Run PHPUnit tests"
	@echo "  make quality   - Run CS-Fixer and PHPStan"

setup:
	composer install
	php bin/console cache:clear

tests:
	vendor/bin/phpunit

quality:
	PHP_CS_FIXER_IGNORE_ENV=1 vendor/bin/php-cs-fixer fix
	vendor/bin/phpstan analyze