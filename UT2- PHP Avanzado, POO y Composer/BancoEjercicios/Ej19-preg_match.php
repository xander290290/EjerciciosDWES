<?php

$codigo = 'LIB-2026-0042';
$valido = preg_match(
    '/^LIB-\d{4}-\d{4}$/',
    $codigo
);

var_dump($valido) . PHP_EOL;

$noValido = preg_match(
    '/^LIB-\d{4}-\d{3}$/',
    $codigo
);

var_dump($noValido) . PHP_EOL;

$false = preg_match(
    '/^LIB-[0-9]{b}-[0-9]{4}$/',
    $codigo
);

echo ($false ? null : 'false');

