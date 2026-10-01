<?php

$libros = [
    [
        'id' => 1,
        'titulo' => 'Dune',
        'paginas' => 435,
        'autor' => 'Frank Herbert',
        'editorial' => 'Minotauro'
    ],
    [
        'id' => 2,
        'titulo' => 'El juego de Ender',
        'paginas' => 234,
        'autor' => 'Orson Scott Card',
        'editorial' => 'Ediciones B'
    ],
    [
        'id' => 3,
        'titulo' => 'El nombre del viento',
        'paginas' => 476,
        'autor' => 'Patrick Rothfuss',
        'editorial' => 'Plaza & Janés'
    ]
];

$libro = array_find(
    $libros,
    fn (array $l): bool => $l['id'] === 2
);

print_r($libro); //Solo muestra el primer elemento que cumple la condicion