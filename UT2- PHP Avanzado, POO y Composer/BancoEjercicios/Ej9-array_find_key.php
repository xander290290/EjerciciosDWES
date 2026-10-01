<?php

$libros = [
    [
    'titulo' => 'El mar de los monstruos',
    'ejemplares' => 5
    ],
    [
    'titulo' => 'El juego de Ender',
    'ejemplares' => 3
    ],
    [
    'titulo' => 'El nombre del viento',
    'ejemplares' => 0
    ]
];

$libro = array_find_key(
    $libros,
    fn (array $l): bool => $l['ejemplares'] === 0
);

print_r($libro); //Solo muestra el primer elemento que cumple la condicion

