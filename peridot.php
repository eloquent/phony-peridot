<?php

use Eloquent\Asplode\Asplode;
use Eloquent\Peridot\Phony\PeridotPhony;
use Evenement\EventEmitterInterface;
use Peridot\Console\Environment;
use Peridot\Reporter\CodeCoverageReporters;
use Peridot\Reporter\ReporterInterface;

require __DIR__ . '/vendor/autoload.php';

Asplode::install();

return function (EventEmitterInterface $emitter) {
    $phony = new PeridotPhony($emitter);
    $phony->install();

    $reporter = new CodeCoverageReporters($emitter);
    $reporter->register();

    $emitter->on('peridot.start', function (Environment $environment) {
        $environment->getDefinition()->getArgument('path')
            ->setDefault('test/suite');
    });

    $emitter->on('code-coverage.start', function (ReporterInterface $reporter) {
        $reporter->addDirectoryToWhitelist(__DIR__ . '/src');
    });
};
