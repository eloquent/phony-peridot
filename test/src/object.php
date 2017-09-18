<?php

try {
    $function = new ReflectionFunction(function (object $a) {});
    $parameters = $function->getParameters();
    $isTypeHintSupported = null === $parameters[0]->getClass();
} catch (ReflectionException $e) {
    $isTypeHintSupported = false;
}

if (!$isTypeHintSupported && !class_exists('object')) {
    eval('class object {}');
}
