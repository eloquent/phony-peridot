test: install
	php --version
	vendor/bin/peridot

coverage: install
	phpdbg --version
	phpdbg -qrr vendor/bin/peridot --reporter html-code-coverage --code-coverage-path=coverage

ci: install
	phpdbg --version
	vendor/bin/peridot
	phpdbg -qrr vendor/bin/peridot --reporter clover-code-coverage --code-coverage-path=coverage/clover.xml

open-coverage:
	open coverage/index.html

lint: install
	vendor/bin/php-cs-fixer fix

install: vendor/autoload.php

web: install $(shell find doc assets/web)
	scripts/build-web

serve: web
	php -S 0.0.0.0:8000 -t web

publish: web
	@scripts/publish-web

.PHONY: test coverage open-coverage lint install serve publish ci

vendor/autoload.php: composer.lock
	composer install

composer.lock: composer.json
	composer update
