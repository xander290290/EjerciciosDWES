<?php

$cadena = ' DRÁCULA ';

$sinEspacios = trim($cadena);

echo $sinEspacios . PHP_EOL;

$minusculas = mb_strtolower($sinEspacios, 'UTF-8');

echo $minusculas . PHP_EOL;

$longitud = mb_strlen($minusculas, 'UTF-8');

echo $longitud . PHP_EOL;