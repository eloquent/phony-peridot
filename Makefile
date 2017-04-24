test: install
	php --version
	vendor/bin/peridot

coverage: install
	phpdbg --version
	phpdbg -qrr vendor/bin/peridot --reporter spec --reporter html-code-coverage --code-coverage-path=coverage

open-coverage:
	open coverage/index.html

lint: test/bin/php-cs-fixer
	test/bin/php-cs-fixer fix --using-cache no

install:
	composer install

.PHONY: test coverage open-coverage lint install

test/bin/php-cs-fixer:
	mkdir -p test/bin
	curl -sSL http://cs.sensiolabs.org/download/php-cs-fixer-v2.phar -o test/bin/php-cs-fixer
	chmod +x test/bin/php-cs-fixer
