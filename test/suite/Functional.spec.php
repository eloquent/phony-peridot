<?php

describe('Functional tests', function () {
    describe('PHP 5 auto-wiring', function (
        array $array,
        stdClass $object,
        callable $callable,
        Closure $closure,
        Generator $generator,
        DateTime $time,
        $bare,
        bool $nullable = null
    ) {
        it('supports auto-wiring for suites', function () use (
            $array,
            $object,
            $callable,
            $closure,
            $generator,
            $time,
            $bare,
            $nullable
        ) {
            expect($array)->to->equal([]);
            expect($object)->to->loosely->equal((object) []);
            expect($callable)->to->be->an->instanceof('Eloquent\Phony\Stub\StubVerifier');
            expect($callable())->to->be->null();
            expect($closure())->to->be->null();
            expect(iterator_to_array($generator))->to->equal([]);
            expect($time)->to->be->an->instanceof('Eloquent\Phony\Mock\Mock');
            expect($bare)->to->be->null();
            expect($nullable)->to->be->null();
        });

        it('supports auto-wiring for tests', function (
            array $array,
            stdClass $object,
            callable $callable,
            Closure $closure,
            Generator $generator,
            DateTime $time,
            $bare,
            bool $nullable = null
        ) {
            expect($array)->to->equal([]);
            expect($object)->to->loosely->equal((object) []);
            expect($callable)->to->be->an->instanceof('Eloquent\Phony\Stub\StubVerifier');
            expect($callable())->to->be->null();
            expect($closure())->to->be->null();
            expect(iterator_to_array($generator))->to->equal([]);
            expect($time)->to->be->an->instanceof('Eloquent\Phony\Mock\Mock');
            expect($bare)->to->be->null();
            expect($nullable)->to->be->null();
        });
    });

    describe('PHP 7 auto-wiring', function (
        bool $bool,
        int $int,
        float $float,
        string $string
    ) {
        it('supports auto-wiring for suites', function () use (
            $bool,
            $int,
            $float,
            $string
        ) {
            expect($bool)->to->be->false();
            expect($int)->to->equal(0);
            expect($float)->to->equal(.0);
            expect($string)->to->equal('');
        });

        it('supports auto-wiring for tests', function (
            bool $bool,
            int $int,
            float $float,
            string $string
        ) {
            expect($bool)->to->be->false();
            expect($int)->to->equal(0);
            expect($float)->to->equal(.0);
            expect($string)->to->equal('');
        });
    });

    if (version_compare(PHP_VERSION, '7.1.x', '<')) {
        return;
    }

    describe('PHP 7.1 auto-wiring', function (iterable $iterable) {
        it('supports auto-wiring for suites', function () use ($iterable) {
            expect($iterable)->to->equal([]);
        });

        it('supports auto-wiring for tests', function (iterable $iterable) {
            expect($iterable)->to->equal([]);
        });
    });

    if (version_compare(PHP_VERSION, '7.2.x', '<')) {
        return;
    }

    describe('PHP 7.2 auto-wiring', function (object $object) {
        it('supports auto-wiring for suites', function () use ($object) {
            expect($object)->to->loosely->equal((object) []);
        });

        it('supports auto-wiring for tests', function (object $object) {
            expect($object)->to->loosely->equal((object) []);
        });
    });
});
