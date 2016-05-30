test: install
	php --version
	vendor/bin/peridot

coverage: install
	phpdbg --version
	phpdbg -qrr vendor/bin/peridot --reporter html-code-coverage --code-coverage-path=coverage

lint: install
	vendor/bin/php-cs-fixer fix

install: vendor/autoload.php

web: $(shell find doc assets/web)
	scripts/build-web

serve: web
	php -S localhost:8000 -t web

publish: web
	@scripts/publish-web

.PHONY: test coverage lint install serve publish

vendor/autoload.php: composer.lock
	composer install

composer.lock: composer.json
	composer update
