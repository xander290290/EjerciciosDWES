<?php

$generos = ['terror','fantasia','comedia'];

$clave = array_search(
    'terror',
    $generos,
    true
);

if ($clave !== false) {
    echo (string) 'La posicion es: ' . $clave;
}