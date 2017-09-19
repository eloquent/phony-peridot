<?php

namespace Eloquent\Phony\Peridot;

use Eloquent\Phony as x;
use Peridot\Core\Suite;
use Peridot\Core\Test;

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

    it('supports typehints', function () {
        $test = new Test(
            'test-c',
            function (bool $bool, int $int, string $string, $bare) {}
        );
        $this->suite->addTest($test);
        $this->subject->onSuiteStart($this->suite);
        $actual = $test->getDefinitionArguments();

        expect($actual)->to->be->an('array');

        list($bool, $int, $string, $bare) = $actual;

        expect($bool)->to->be->false();
        expect($int)->to->equal(0);
        expect($string)->to->equal('');
        expect($bare)->to->be->null();
    });
});
