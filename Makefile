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

lint: install
	vendor/bin/php-cs-fixer fix

install: vendor/autoload.php

web: install README.md $(shell find assets/web)
	scripts/build-web

serve: web
	php -S 0.0.0.0:8000 -t web

open-coverage:
	open coverage/index.html

open-web:
	open http://localhost:8000/

.PHONY: test coverage lint install serve ci open-coverage open-web

vendor/autoload.php: composer.lock
	composer install

composer.lock: composer.json
	composer update
