<?php

declare(strict_types=1);

namespace Eloquent\Phony\Peridot\Test;

class TestClassA
{
    public static function testClassAStaticMethodA(): string
    {
        return implode(func_get_args());
    }

    public static function testClassAStaticMethodB(string $first, string $second): string
    {
        return implode(func_get_args());
    }

    public function __construct(string &$first = null, string &$second = null)
    {
        $this->constructorArguments = func_get_args();

        $first = 'first';
        $second = 'second';
    }

    public function testClassAMethodA(): string
    {
        return implode(func_get_args());
    }

    public function testClassAMethodB(string $first, string $second): string
    {
        return implode(func_get_args());
    }

    protected static function testClassAStaticMethodC(): string
    {
        return 'protected ' . implode(func_get_args());
    }

    protected static function testClassAStaticMethodD(string $first, string $second): string
    {
        return 'protected ' . implode(func_get_args());
    }

    protected function testClassAMethodC(): string
    {
        return 'protected ' . implode(func_get_args());
    }

    protected function testClassAMethodD(string &$first, string &$second): string
    {
        return 'protected ' . implode(func_get_args());
    }

    private static function testClassAStaticMethodE(): string
    {
        return 'private ' . implode(func_get_args());
    }

    private function testClassAMethodE(): string
    {
        return 'private ' . implode(func_get_args());
    }

    /**
     * @var array<string>|null
     */
    public $constructorArguments;
}
