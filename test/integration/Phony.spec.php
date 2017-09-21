<?php

use Eloquent\Phony\Phony;

describe('Phony', function () {
    beforeEach(function () {
        $this->handle = Phony::mock('Eloquent\Phony\Peridot\Test\TestClassA');
        $this->mock = $this->handle->get();
    });

    it('should record passing mock assertions', function () {
        $this->mock->testClassAMethodA('aardvark', 'bonobo');

        $this->handle->testClassAMethodA->calledWith('aardvark', 'bonobo');
    });

    it('should record failing mock assertions', function () {
        $this->mock->testClassAMethodA('aardvark', ['bonobo', 'capybara', 'dugong']);
        $this->mock->testClassAMethodA('armadillo', ['bonobo', 'chameleon', 'dormouse']);

        $this->handle->testClassAMethodA->calledWith('aardvark', ['bonobo', 'chameleon', 'dugong']);
    });
});
