<?php

namespace Eloquent\Phony\Peridot;

use Closure;
use DateTime;
use Eloquent\Phony as x;
use Generator;
use Peridot\Core\Suite;
use Peridot\Core\Test;
use ReflectionException;
use ReflectionFunction;
use stdClass;

describe('PeridotPhony', function () {
    beforeEach(function () {
        $this->subject = PeridotPhony::create();

        $this->suite = new Suite('suite-a', function ($a1, $a2) {});
        $this->testA = new Test('test-a', function ($a1, $a2) {});
        $this->suite->addTest($this->testA);
        $this->testB = new Test('test-a', function ($a1, $a2) {});
        $this->suite->addTest($this->testB);
    });

    it('attach()', function () {
        $emitter = x\mock('Evenement\EventEmitterInterface');
        $this->subject->install($emitter->get());

        $emitter->on->calledWith('suite.define', [$this->subject, 'onSuiteDefine']);
        $emitter->on->calledWith('suite.start', [$this->subject, 'onSuiteStart']);
    });

    it('detach()', function () {
        $emitter = x\mock('Evenement\EventEmitterInterface');
        $this->subject->detach($emitter->get());

        $emitter->removeListener->calledWith('suite.define', [$this->subject, 'onSuiteDefine']);
        $emitter->removeListener->calledWith('suite.start', [$this->subject, 'onSuiteStart']);
    });

    it('onSuiteDefine()', function () {
        $this->subject->onSuiteDefine($this->suite);

        expect($this->suite->getDefinitionArguments())->to->equal([null, null]);
    });

    it('onSuiteStart()', function () {
        $this->subject->onSuiteStart($this->suite);

        expect($this->testA->getDefinitionArguments())->to->equal([null, null]);
        expect($this->testB->getDefinitionArguments())->to->equal([null, null]);
    });

    it('supports PHP 5 typehints', function () {
        $test = new Test(
            'test-c',
            function (
                array $array,
                stdClass $object,
                callable $callable,
                Closure $closure,
                Generator $generator,
                DateTime $time,
                $bare,
                stdClass $nullable = null
            ) {}
        );
        $this->suite->addTest($test);
        $this->subject->onSuiteStart($this->suite);
        $actual = $test->getDefinitionArguments();

        expect($actual)->to->be->an('array');

        list(
            $array,
            $object,
            $callable,
            $closure,
            $generator,
            $time,
            $bare,
            $nullable
        ) = $actual;

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

    if (version_compare(PHP_VERSION, '7.x', '<')) {
        return;
    }

    it('supports PHP 7 typehints', function () {
        $test = new Test(
            'test-c',
            function (
                bool $bool,
                int $int,
                float $float,
                string $string
            ) {}
        );
        $this->suite->addTest($test);
        $this->subject->onSuiteStart($this->suite);
        $actual = $test->getDefinitionArguments();

        expect($actual)->to->be->an('array');

        list(
            $bool,
            $int,
            $float,
            $string
        ) = $actual;

        expect($bool)->to->be->false();
        expect($int)->to->equal(0);
        expect($float)->to->equal(.0);
        expect($string)->to->equal('');
    });

    try {
        $function = new ReflectionFunction(function (iterable $a) {});
        $parameters = $function->getParameters();
        $isIterableTypeSupported = null === $parameters[0]->getClass();
    } catch (ReflectionException $e) {
        $isIterableTypeSupported = false;
    }

    if ($isIterableTypeSupported) {
        it('supports PHP 7.1 typehints', function () {
            $test = new Test(
                'test-c',
                function (
                    iterable $iterable
                ) {}
            );
            $this->suite->addTest($test);
            $this->subject->onSuiteStart($this->suite);
            $actual = $test->getDefinitionArguments();

            expect($actual)->to->be->an('array');

            list(
                $iterable
            ) = $actual;

            expect($iterable)->to->equal([]);
        });
    }

    if (version_compare(PHP_VERSION, '7.2.x', '<')) {
        it('supports the object type hint before PHP 7.2', function () {
            $test = new Test(
                'test-c',
                eval('return function (object $object) {};')
            );
            $this->suite->addTest($test);
            $this->subject->onSuiteStart($this->suite);
            $actual = $test->getDefinitionArguments();

            expect($actual)->to->be->an('array');

            list(
                $object,
            ) = $actual;

            expect($object)->to->be->an->instanceof('object');
        });
    } else {
        it('supports PHP 7.2 typehints', function () {
            $test = new Test(
                'test-c',
                function (
                    object $object
                ) {}
            );
            $this->suite->addTest($test);
            $this->subject->onSuiteStart($this->suite);
            $actual = $test->getDefinitionArguments();

            expect($actual)->to->be->an('array');

            list(
                $object,
            ) = $actual;

            expect($object)->to->loosely->equal((object) []);
        });
    }
});
