<?php

$catalogo = [
    10 => [
        'titulo' => 'El Quijote',
        'autor' => 'Cervantes'
    ],
    20 => [
        'titulo' => '1984',
        'autor' => 'George Orwell'
    ],
    30 => [
        'titulo' => 'Cien años de soledad',
        'autor' => 'García Márquez'
    ]
];

uasort(
    $catalogo,
    fn (array $a, array $b): int => $a['titulo'] <=> $b['titulo']
);

print_r($catalogo); //Las claves se mantienen