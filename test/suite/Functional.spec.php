<?php

declare(strict_types=1);

describe('Functional tests', function () {
    describe('auto-wiring', function (bool $bool, int $int, string $string) {
        it('supports auto-wiring for suites', function () use ($bool, $int, $string) {
            expect($bool)->to->be->false();
            expect($int)->to->equal(0);
            expect($string)->to->equal('');
        });

        it('supports auto-wiring for tests', function (bool $bool, int $int, string $string) {
            expect($bool)->to->be->false();
            expect($int)->to->equal(0);
            expect($string)->to->equal('');
        });
    });
});
