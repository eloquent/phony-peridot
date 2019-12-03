<?php

declare(strict_types=1);

use Eloquent\Phony\Call\CallVerifier;
use Eloquent\Phony\Event\EventSequence;
use Eloquent\Phony\Mock\Mock;
use function Eloquent\Phony\on;
use Eloquent\Phony\Stub\StubVerifier;

describe('Phony for Peridot', function () {
    it('Auto-wires test dependencies', function (PDO $db) {
        if (!$db instanceof Mock) {
            throw new RuntimeException('Auto-injected mock is not a mock');
        }

        expect($db)->to->be->an->instanceof('PDO');
    });

    it('Supports stubbing', function (PDO $db) {
        if (!$db instanceof Mock) {
            throw new RuntimeException('Auto-injected mock is not a mock');
        }

        on($db)->exec->with('DELETE FROM users')->returns(111);

        expect($db->exec('DELETE FROM users'))->to->equal(111);
    });

    it('Supports verification', function (PDO $db) {
        if (!$db instanceof Mock) {
            throw new RuntimeException('Auto-injected mock is not a mock');
        }

        $db->exec('DROP TABLE users');

        on($db)->exec->calledWith('DROP TABLE users');
    });

    it('Supports callable stubs', function (callable $stub) {
        if (!$stub instanceof StubVerifier) {
            throw new RuntimeException('Auto-injected stub is not a stub');
        }

        $stub->with('a', 'b')->returns('c');
        $stub('a', 'b');

        /** @var EventSequence */
        $called = $stub->calledWith('a', 'b');
        /** @var CallVerifier */
        $call = $called->firstCall();
        $call->returned('c');
    });
});
