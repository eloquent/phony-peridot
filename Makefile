.PHONY: test
test: install
	php --version
	vendor/bin/peridot

.PHONY: coverage
coverage: install
	phpdbg --version
	phpdbg -qrr vendor/bin/peridot --reporter spec --reporter html-code-coverage

.PHONY: open-coverage
open-coverage:
	open coverage/index.html

.PHONY: ci
ci:
	phpdbg --version
	phpdbg -qrr vendor/bin/peridot --reporter spec --reporter clover-code-coverage

.PHONY: integration
integration: install
	test/integration/run

.PHONY: lint
lint: install
	vendor/bin/php-cs-fixer fix

.PHONY: install
install:
ifeq (${TRAVIS_PHP_VERSION},nightly)
	composer install --ignore-platform-reqs
else
	composer install
endif
