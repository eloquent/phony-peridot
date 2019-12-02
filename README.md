# Phony for Peridot

[![Current version image][version-image]][current version]

[current version]: https://packagist.org/packages/eloquent/phony-peridot
[version-image]: https://img.shields.io/packagist/v/eloquent/phony-peridot.svg?style=flat-square "This project uses semantic versioning"

## Installation

    composer require --dev eloquent/phony-peridot

## See also

- Read the [documentation].
- Read the [Peridot documentation].
- Visit the [main Phony repository].

[documentation]: http://eloquent-software.com/phony/latest/
[main phony repository]: https://github.com/eloquent/phony
[peridot documentation]: http://peridot-php.github.io/

## What is *Phony for Peridot*?

*Phony for Peridot* is a plugin for the [Peridot] testing framework that
provides auto-wired test dependencies via the [Phony] mocking framework.

In other words, if a [Peridot] test (or suite) requires a mock object, it can be
defined to have a parameter with an appropriate [type declaration], and it will
automatically receive a mock of that type as an argument when run.

[Stubs] for `callable` types, and "empty" values for other type declarations are
also [supported].

## Plugin installation

The plugin must be installed in the [Peridot configuration file]:

```php
use Eloquent\Phony\Peridot\PeridotPhony;
use Evenement\EventEmitterInterface;

return function (EventEmitterInterface $emitter) {
    PeridotPhony::install($emitter);
};
```

## Dependency injection

Once the plugin is installed, any tests or suites that are defined with
parameters will be supplied with matching arguments when run:

```php
describe('Phony for Peridot', function () {
    it('Auto-wires test dependencies', function (PDO $db) {
        expect($db)->to->be->an->instanceof('PDO');
    });
});
```

### Injected mock objects

*Phony for Peridot* supports automatic injection of [mock objects]. Because
[Phony] doesn't alter the interface of mocked objects, it is necessary to use
[`on()`] to retrieve the [mock handle] in order to perform [stubbing] and
[verification]:

```php
use function Eloquent\Phony\on;

describe('Phony for Peridot', function () {
    it('Supports stubbing', function (PDO $db) {
        on($db)->exec->with('DELETE FROM users')->returns(111);

        expect($db->exec('DELETE FROM users'))->to->equal(111);
    });

    it('Supports verification', function (PDO $db) {
        $db->exec('DROP TABLE users');

        on($db)->exec->calledWith('DROP TABLE users');
    });
});
```

### Injected stubs

*Phony for Peridot* supports automatic injection of [stubs] for parameters with
a `callable` type declaration:

```php
describe('Phony for Peridot', function () {
    it('Supports callable stubs', function (callable $stub) {
        $stub->with('a', 'b')->returns('c');
        $stub('a', 'b');

        $stub->calledWith('a', 'b')->firstCall()->returned('c');
    });
});
```

## Supported types

The following table lists the supported type declarations, and the value
supplied for each:

Parameter type | Supplied value
---------------|---------------
*(none)*       | `null`
`bool`         | `false`
`int`          | `0`
`float`        | `.0`
`string`       | `''`
`array`        | `[]`
`stdClass`     | `(object) []`
`callable`     | [`stub()`]
`Closure`      | `function () {}`
`Generator`    | `(function () {return; yield;})()`

When using a [type declaration] that is not listed above, the supplied value
will be a [mock] of the specified type.

By necessity, the supplied value will not be wrapped in a [mock handle]. In
order to obtain a handle, simply use [`on()`]:

```php
use function Eloquent\Phony\on;

it('Example mock handle retrieval', function (ClassA $mock) {
    $handle = on($mock);
});
```

## License

For the full copyright and license information, please view the [LICENSE file].

<!-- References -->

[`on()`]: http://eloquent-software.com/phony/latest/#facade.on
[`stub()`]: http://eloquent-software.com/phony/latest/#facade.stub
[license file]: LICENSE
[mock handle]: http://eloquent-software.com/phony/latest/#mock-handles
[mock objects]: http://eloquent-software.com/phony/latest/#mocks
[mock]: http://eloquent-software.com/phony/latest/#mocks
[peridot configuration file]: http://peridot-php.github.io/plugins.html
[peridot]: http://peridot-php.github.io/
[phony]: http://eloquent-software.com/phony/latest/
[stubbing]: http://eloquent-software.com/phony/latest/#stubs
[stubs]: http://eloquent-software.com/phony/latest/#stubs
[supported]: #supported-types
[type declaration]: http://php.net/functions.arguments#functions.arguments.type-declaration
[verification]: http://eloquent-software.com/phony/latest/#verification
