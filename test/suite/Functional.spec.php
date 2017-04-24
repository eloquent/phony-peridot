<?php

/*
 * This file is part of the Phony for Peridot package.
 *
 * Copyright © 2017 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

describe('Functional tests', function () {
    describe('PHP 5 auto-wiring', function (
        array $array,
        stdClass $object,
        callable $callable,
        Closure $closure,
        DateTime $time,
        $bare,
        bool $nullable = null
    ) {
        it('supports auto-wiring for suites', function () use (
            $array,
            $object,
            $callable,
            $closure,
            $time,
            $bare,
            $nullable
        ) {
            expect($array)->to->equal([]);
            expect($object)->to->loosely->equal((object) []);
            expect($callable)->to->be->an->instanceof('Eloquent\Phony\Stub\StubVerifier');
            expect($callable())->to->be->null();
            expect($closure())->to->be->null();
            expect($time)->to->be->an->instanceof('Eloquent\Phony\Mock\Mock');
            expect($bare)->to->be->null();
            expect($nullable)->to->be->null();
        });

        it('supports auto-wiring for tests', function (
            array $array,
            stdClass $object,
            callable $callable,
            Closure $closure,
            DateTime $time,
            $bare,
            bool $nullable = null
        ) {
            expect($array)->to->equal([]);
            expect($object)->to->loosely->equal((object) []);
            expect($callable)->to->be->an->instanceof('Eloquent\Phony\Stub\StubVerifier');
            expect($callable())->to->be->null();
            expect($closure())->to->be->null();
            expect($time)->to->be->an->instanceof('Eloquent\Phony\Mock\Mock');
            expect($bare)->to->be->null();
            expect($nullable)->to->be->null();
        });
    });

    if (version_compare(PHP_VERSION, '7.x', '<')) {
        return;
    }

    describe('PHP 7 auto-wiring', function (
        bool $bool,
        int $int,
        float $float,
        string $string,
        Generator $generator
    ) {
        it('supports auto-wiring for suites', function () use (
            $bool,
            $int,
            $float,
            $string,
            $generator
        ) {
            expect($bool)->to->be->false();
            expect($int)->to->equal(0);
            expect($float)->to->equal(.0);
            expect($string)->to->equal('');
            expect(iterator_to_array($generator))->to->equal([]);
        });

        it('supports auto-wiring for tests', function (
            bool $bool,
            int $int,
            float $float,
            string $string,
            Generator $generator
        ) {
            expect($bool)->to->be->false();
            expect($int)->to->equal(0);
            expect($float)->to->equal(.0);
            expect($string)->to->equal('');
            expect(iterator_to_array($generator))->to->equal([]);
        });
    });
});
