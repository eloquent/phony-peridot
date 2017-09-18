.PHONY: test
test: install
	php --version
	vendor/bin/peridot

.PHONY: test-hhvm
test-hhvm: install
	test/bin/hhvm-3.21 sh -c "php --version; PHP_ERROR_EXCEPTION_DEPRECATIONS=1 php -d 'hhvm.php7.all=1' -d 'hhvm.hack.lang.look_for_typechecker=0' vendor/bin/peridot"

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
lint: test/bin/php-cs-fixer
	test/bin/php-cs-fixer fix --using-cache no

.PHONY: install
install:
	composer install

test/bin/php-cs-fixer:
	mkdir -p test/bin
	curl -sSL http://cs.sensiolabs.org/download/php-cs-fixer-v2.phar -o test/bin/php-cs-fixer
	chmod +x test/bin/php-cs-fixer
