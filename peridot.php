<?php

use Eloquent\Asplode\Asplode;
use Eloquent\Peridot\Phony\PeridotPhony;
use Evenement\EventEmitterInterface;
use Peridot\Console\Environment;
use Peridot\Reporter\CodeCoverageReporters;
use Peridot\Reporter\ReporterInterface;

Asplode::install();

return function (EventEmitterInterface $emitter) {
    PeridotPhony::install($emitter);

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
