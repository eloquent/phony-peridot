<?php

/*
 * This file is part of the Phony for Peridot package.
 *
 * Copyright © 2016 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

describe('functional tests', function () {
    describe('scope methods', function () {
        it('mockBuilder()', function () {
            $actual = $this->mockBuilder();

            expect($actual)->to->be->an->instanceof('Eloquent\Phony\Mock\Builder\MockBuilder');

            $actual = $this->mockBuilder('DateTime');

            expect($actual)->to->be->an->instanceof('Eloquent\Phony\Mock\Builder\MockBuilder');
            expect($actual->get())->to->be->an->instanceof('DateTime');
        });

        it('mock()', function () {
            $actual = $this->mock();

            expect($actual)->to->be->an->instanceof('Eloquent\Phony\Mock\Handle\InstanceHandle');

            $actual = $this->mock('DateTime');

            expect($actual)->to->be->an->instanceof('Eloquent\Phony\Mock\Handle\InstanceHandle');
            expect($actual->mock())->to->be->an->instanceof('DateTime');
        });

        it('partialMock()', function () {
            $actual = $this->partialMock();

            expect($actual)->to->be->an->instanceof('Eloquent\Phony\Mock\Handle\InstanceHandle');

            $actual = $this->partialMock('DateTime', ['2001-02-03T04:05:06Z']);

            expect($actual)->to->be->an->instanceof('Eloquent\Phony\Mock\Handle\InstanceHandle');
            expect($actual->mock())->to->be->an->instanceof('DateTime');
            expect($actual->mock()->format('c'))->to->equal('2001-02-03T04:05:06+00:00');
        });

        it('on()', function () {
            $handle = $this->mock();
            $actual = $this->on($handle->mock());

            expect($actual)->to->equal($handle);
        });

        it('verify()', function () {
            $handle = $this->mock();
            $actual = $this->verify($handle->mock());

            expect($actual)->to->be->an->instanceof('Eloquent\Phony\Mock\Handle\InstanceHandle');
            expect($actual)->to->be->an->instanceof('Eloquent\Phony\Mock\Handle\Verification\VerificationHandle');
        });

        it('onStatic()', function () {
            $handle = $this->mock();
            $actual = $this->onStatic(get_class($handle->mock()));

            expect($actual)->to->be->an->instanceof('Eloquent\Phony\Mock\Handle\StaticHandle');
            expect($actual)->to->be->an->instanceof('Eloquent\Phony\Mock\Handle\Stubbing\StubbingHandle');
        });

        it('verifyStatic()', function () {
            $handle = $this->mock();
            $actual = $this->verifyStatic(get_class($handle->mock()));

            expect($actual)->to->be->an->instanceof('Eloquent\Phony\Mock\Handle\StaticHandle');
            expect($actual)->to->be->an->instanceof('Eloquent\Phony\Mock\Handle\Verification\VerificationHandle');
        });

        it('spy()', function () {
            $actual = $this->spy();

            expect($actual)->to->be->an->instanceof('Eloquent\Phony\Spy\SpyVerifier');
            expect($actual())->to->be->null();

            $actual = $this->spy('implode');

            expect($actual)->to->be->an->instanceof('Eloquent\Phony\Spy\SpyVerifier');
            expect($actual(',', ['a', 'b']))->to->equal('a,b');
        });

        it('stub()', function () {
            $actual = $this->stub();

            expect($actual)->to->be->an->instanceof('Eloquent\Phony\Stub\StubVerifier');
            expect($actual())->to->be->null();

            $actual = $this->stub('implode');

            expect($actual)->to->be->an->instanceof('Eloquent\Phony\Stub\StubVerifier');
            expect($actual(',', ['a', 'b']))->to->equal('a,b');
        });
    });

    if (!method_exists('ReflectionParameter', 'getType')) {
        return;
    }

    describe('auto-wiring', function (
        bool $bool,
        int $int,
        float $float,
        string $string,
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
            $bool,
            $int,
            $float,
            $string,
            $array,
            $object,
            $callable,
            $closure,
            $generator,
            $time,
            $bare,
            $nullable
        ) {
            expect($bool)->to->be->false();
            expect($int)->to->equal(0);
            expect($float)->to->equal(.0);
            expect($string)->to->equal('');
            expect($array)->to->equal([]);
            expect($object)->to->loosely->equal((object) []);
            expect($callable)->to->be->an->instanceof('Eloquent\Phony\Spy\SpyVerifier');
            expect($callable())->to->be->null();
            expect($closure())->to->be->null();
            expect(iterator_to_array($generator))->to->equal([]);
            expect($time)->to->be->an->instanceof('Eloquent\Phony\Mock\Mock');
            expect($bare)->to->be->null();
            expect($nullable)->to->be->null();
        });

        it('supports auto-wiring for tests', function (
            bool $bool,
            int $int,
            float $float,
            string $string,
            array $array,
            stdClass $object,
            callable $callable,
            Closure $closure,
            Generator $generator,
            DateTime $time,
            $bare,
            bool $nullable = null
        ) {
            expect($bool)->to->be->false();
            expect($int)->to->equal(0);
            expect($float)->to->equal(.0);
            expect($string)->to->equal('');
            expect($array)->to->equal([]);
            expect($object)->to->loosely->equal((object) []);
            expect($callable)->to->be->an->instanceof('Eloquent\Phony\Spy\SpyVerifier');
            expect($callable())->to->be->null();
            expect($closure())->to->be->null();
            expect(iterator_to_array($generator))->to->equal([]);
            expect($time)->to->be->an->instanceof('Eloquent\Phony\Mock\Mock');
            expect($bare)->to->be->null();
            expect($nullable)->to->be->null();
        });
    });
});
