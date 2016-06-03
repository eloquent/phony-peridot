<?php

use Eloquent\Asplode\Asplode;
use Eloquent\Phony\Leo\PhonyLeo;
use Eloquent\Phony\Peridot\PhonyPeridot;
use Evenement\EventEmitterInterface;
use Peridot\Leo\Leo;
use Peridot\Reporter\CodeCoverageReporters;

require __DIR__ . '/vendor/autoload.php';

Asplode::install();

return function (EventEmitterInterface $emitter) {
    $phony = new PhonyPeridot($emitter);
    $phony->install();

    Leo::assertion()->extend(new PhonyLeo());

    $reporter = new CodeCoverageReporters($emitter);
    $reporter->register();

    $emitter->on('peridot.start', function ($environment) {
        $environment->getDefinition()->getArgument('path')
            ->setDefault('test/suite');
    });

    $emitter->on('code-coverage.start', function ($reporter) {
        $reporter->addDirectoryToWhitelist(__DIR__ . '/src');
    });
};
