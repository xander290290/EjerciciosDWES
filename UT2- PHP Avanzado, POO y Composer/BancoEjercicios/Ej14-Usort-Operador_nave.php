<?php

$libros = [
    [
        'titulo' => 'El señor de los anillos',
        'paginas' => 1504
    ],
    [
        'titulo' => 'El hobbit',
        'paginas' => 328
    ],
    [
        'titulo' => 'El quijote',
        'paginas' => 412
    ]
];

usort(
    $libros,
    fn (array $a, array $b): int => $a['paginas'] <=> $b['paginas']
);

print_r($libros); //Las claves cambian

usort(
    $libros,
    fn (array $a, array $b): int => $b['paginas'] <=> $a['paginas']
);

print_r($libros);