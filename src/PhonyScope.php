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

use Eloquent\Phony\Phony;
use Peridot\Scope\Scope;

/**
 * A Peridot scope for Phony integration.
 */
class PhonyScope extends Scope
{
    public function mockBuilder($types = [])
    {
        return Phony::mockBuilder($types);
    }

    public function mock($types = [])
    {
        return Phony::mock($types);
    }

    public function partialMock($types = [], $arguments = [])
    {
        return Phony::partialMock($types, $arguments);
    }

    public function on($mock)
    {
        return Phony::on($mock);
    }

    public function verify($mock)
    {
        return Phony::verify($mock);
    }

    public function onStatic($class)
    {
        return Phony::onStatic($class);
    }

    public function verifyStatic($class)
    {
        return Phony::verifyStatic($class);
    }

    public function spy($callback = null)
    {
        return Phony::spy($callback);
    }

    public function stub($callback = null)
    {
        return Phony::stub($callback);
    }
}
