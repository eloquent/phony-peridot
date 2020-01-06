<?php

declare(strict_types=1);

namespace Eloquent\Phony\Peridot;

use Eloquent\Phony\Phony;
use Evenement\EventEmitterInterface;
use Peridot\Core\Suite;
use ReflectionFunction;

/**
 * A Peridot plugin for Phony integration.
 */
class PeridotPhony
{
    /**
     * Install a new Peridot Phony plugin to the supplied emitter.
     *
     * @return self The newly created plugin.
     */
    public static function install(EventEmitterInterface $emitter): self
    {
        $instance = new self();
        $instance->attach($emitter);

        return $instance;
    }

    /**
     * Create a new Peridot Phony plugin.
     *
     * @return self The newly created plugin.
     */
    public static function create(): self
    {
        return new self();
    }

    /**
     * Attach the plugin.
     */
    public function attach(EventEmitterInterface $emitter): void
    {
        $emitter->on('suite.define', [$this, 'onSuiteDefine']);
        $emitter->on('suite.start', [$this, 'onSuiteStart']);
    }

    /**
     * Detach the plugin.
     */
    public function detach(EventEmitterInterface $emitter): void
    {
        $emitter->removeListener('suite.define', [$this, 'onSuiteDefine']);
        $emitter->removeListener('suite.start', [$this, 'onSuiteStart']);
    }

    /**
     * Handle the definition of a suite.
     *
     * @access private
     */
    public function onSuiteDefine(Suite $suite): void
    {
        $definition = new ReflectionFunction($suite->getDefinition());
        $parameters = $definition->getParameters();

        if ($parameters) {
            $suite->setDefinitionArguments(
                $this->parameterArguments($parameters)
            );
        }
    }

    /**
     * Handle the start of a suite.
     *
     * @access private
     */
    public function onSuiteStart(Suite $suite): void
    {
        foreach ($suite->getTests() as $test) {
            $definition = new ReflectionFunction($test->getDefinition());
            $parameters = $definition->getParameters();

            if ($parameters) {
                $test->setDefinitionArguments(
                    $this->parameterArguments($parameters)
                );
            }
        }
    }

    private function __construct()
    {
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return array<mixed>
     */
    private function parameterArguments(array $parameters): array
    {
        $arguments = [];

        foreach ($parameters as $parameter) {
            if ($type = $parameter->getType()) {
                $arguments[] = Phony::emptyValue($type);
            } else {
                $arguments[] = null;
            }
        }

        return $arguments;
    }
}
