<?php

/*
 * This file is part of the Phony for Peridot package.
 *
 * Copyright © 2016 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Eloquent\Phony\Peridot;

use Closure;
use DateTime;
use Eloquent\Phony as x;
use Generator;
use Peridot\Core\Suite;
use Peridot\Core\Test;
use stdClass;

describe('PhonyPeridot', function () {
    beforeEach(function () {
        $this->emitter = x\mock('Evenement\EventEmitterInterface');
        $this->subject = new PhonyPeridot($this->emitter->get());

        $this->suite = new Suite('suite-a', function ($a1, $a2) {});
        $this->testA = new Test('test-a', function ($a1, $a2) {});
        $this->suite->addTest($this->testA);
        $this->testB = new Test('test-a', function ($a1, $a2) {});
        $this->suite->addTest($this->testB);
    });

    it('install()', function () {
        $this->subject->install();

        $this->emitter->on->calledWith('suite.define', [$this->subject, 'onSuiteDefine']);
        $this->emitter->on->calledWith('suite.start', [$this->subject, 'onSuiteStart']);
    });

    it('uninstall()', function () {
        $this->subject->uninstall();

        $this->emitter->removeListener->calledWith('suite.define', [$this->subject, 'onSuiteDefine']);
        $this->emitter->removeListener->calledWith('suite.start', [$this->subject, 'onSuiteStart']);
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
            $time,
            $bare,
            $nullable
        ) = $actual;

        expect($array)->to->equal([]);
        expect($object)->to->loosely->equal((object) []);
        expect($callable)->to->be->an->instanceof('Eloquent\Phony\Spy\SpyVerifier');
        expect($callable())->to->be->null();
        expect($closure())->to->be->null();
        expect($time)->to->be->an->instanceof('Eloquent\Phony\Mock\Mock');
        expect($bare)->to->be->null();
        expect($nullable)->to->be->null();
    });

    if (!method_exists('ReflectionParameter', 'getType')) {
        return;
    }

    it('supports PHP 7 typehints', function () {
        $test = new Test(
            'test-c',
            function (
                bool $bool,
                int $int,
                float $float,
                string $string,
                Generator $generator
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
            $string,
            $generator
        ) = $actual;

        expect($bool)->to->be->false();
        expect($int)->to->equal(0);
        expect($float)->to->equal(.0);
        expect($string)->to->equal('');
        expect(iterator_to_array($generator))->to->equal([]);
    });
});
