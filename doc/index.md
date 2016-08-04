# Phony for Peridot

- [Installation]
- [Help]
- [Usage]

## Installation

Available as [Composer] package [eloquent/peridot-phony].

## Help

For help with a difficult testing scenario, questions regarding how to use
*Phony*, or to report issues with *Phony* itself, please open a [GitHub issue]
so that others may benefit from the outcome.

Alternatively, [@ezzatron] may be contacted directly via [Twitter].

## Usage

The plugin must be installed in the [Peridot] configuration:

```php
<?php // peridot.php

use Eloquent\Peridot\Phony\PeridotPhony;
use Evenement\EventEmitterInterface;

return function (EventEmitterInterface $emitter) {
    PeridotPhony::install($emitter);

    // ...
};
```

In order to perform stubbing and verification, it is necessary to use
[`on()`] to retrieve the [mock handle] first:

```php
<?php // example.spec.php

use Eloquent\Phony as x;

describe('Phony for Peridot', function () {
    it('Auto-wires test dependencies', function (PDO $db) {
        expect($db)->to->be->an->instanceof('PDO');
    });

    it('Supports stubbing', function (PDO $db) {
        x\on($db)->exec->with('DELETE FROM users')->returns(111);

        expect($db->exec('DELETE FROM users'))->to->equal(111);
    });

    it('Supports verification', function (PDO $db) {
        $db->exec('DROP TABLE users');

        x\on($db)->exec->calledWith('DROP TABLE users');
    });
});
```

<!-- Heading references -->

[help]: #help
[installation]: #installation
[usage]: #usage

<!-- External references -->

[@ezzatron]: https://github.com/ezzatron
[`on()`]: http://eloquent-software.com/phony/latest/#facade.on
[composer]: http://getcomposer.org/
[eloquent/peridot-phony]: https://packagist.org/packages/eloquent/peridot-phony
[github issue]: https://github.com/eloquent/peridot-phony/issues
[mock handle]: http://eloquent-software.com/phony/latest/#mock-handles
[peridot]: http://peridot-php.github.io/
[twitter]: https://twitter.com/ezzatron
