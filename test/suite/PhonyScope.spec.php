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

describe('PhonyScope', function () {
    beforeEach(function () {
        $this->subject = new PhonyScope();
    });

    it('mockBuilder()', function () {
        $actual = $this->subject->mockBuilder();

        expect($actual)->to->be->an->instanceof('Eloquent\Phony\Mock\Builder\MockBuilder');

        $actual = $this->subject->mockBuilder('DateTime');

        expect($actual)->to->be->an->instanceof('Eloquent\Phony\Mock\Builder\MockBuilder');
        expect($actual->get())->to->be->an->instanceof('DateTime');
    });

    it('mock()', function () {
        $actual = $this->subject->mock();

        expect($actual)->to->be->an->instanceof('Eloquent\Phony\Mock\Handle\InstanceHandle');

        $actual = $this->subject->mock('DateTime');

        expect($actual)->to->be->an->instanceof('Eloquent\Phony\Mock\Handle\InstanceHandle');
        expect($actual->mock())->to->be->an->instanceof('DateTime');
    });

    it('partialMock()', function () {
        $actual = $this->subject->partialMock();

        expect($actual)->to->be->an->instanceof('Eloquent\Phony\Mock\Handle\InstanceHandle');

        $actual = $this->subject->partialMock('DateTime', ['2001-02-03T04:05:06Z']);

        expect($actual)->to->be->an->instanceof('Eloquent\Phony\Mock\Handle\InstanceHandle');
        expect($actual->mock())->to->be->an->instanceof('DateTime');
        expect($actual->mock()->format('c'))->to->equal('2001-02-03T04:05:06+00:00');
    });

    it('on()', function () {
        $handle = $this->subject->mock();
        $actual = $this->subject->on($handle->mock());

        expect($actual)->to->equal($handle);
    });

    it('verify()', function () {
        $handle = $this->subject->mock();
        $actual = $this->subject->verify($handle->mock());

        expect($actual)->to->be->an->instanceof('Eloquent\Phony\Mock\Handle\InstanceHandle');
        expect($actual)->to->be->an->instanceof('Eloquent\Phony\Mock\Handle\Verification\VerificationHandle');
    });

    it('onStatic()', function () {
        $handle = $this->subject->mock();
        $actual = $this->subject->onStatic(get_class($handle->mock()));

        expect($actual)->to->be->an->instanceof('Eloquent\Phony\Mock\Handle\StaticHandle');
        expect($actual)->to->be->an->instanceof('Eloquent\Phony\Mock\Handle\Stubbing\StubbingHandle');
    });

    it('verifyStatic()', function () {
        $handle = $this->subject->mock();
        $actual = $this->subject->verifyStatic(get_class($handle->mock()));

        expect($actual)->to->be->an->instanceof('Eloquent\Phony\Mock\Handle\StaticHandle');
        expect($actual)->to->be->an->instanceof('Eloquent\Phony\Mock\Handle\Verification\VerificationHandle');
    });

    it('spy()', function () {
        $actual = $this->subject->spy();

        expect($actual)->to->be->an->instanceof('Eloquent\Phony\Spy\SpyVerifier');
        expect($actual())->to->be->null();

        $actual = $this->subject->spy('implode');

        expect($actual)->to->be->an->instanceof('Eloquent\Phony\Spy\SpyVerifier');
        expect($actual(',', ['a', 'b']))->to->equal('a,b');
    });

    it('stub()', function () {
        $actual = $this->subject->stub();

        expect($actual)->to->be->an->instanceof('Eloquent\Phony\Stub\StubVerifier');
        expect($actual())->to->be->null();

        $actual = $this->subject->stub('implode');

        expect($actual)->to->be->an->instanceof('Eloquent\Phony\Stub\StubVerifier');
        expect($actual(',', ['a', 'b']))->to->equal('a,b');
    });
});
