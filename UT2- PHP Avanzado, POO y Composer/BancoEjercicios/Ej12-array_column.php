<?php

$libros = [
    [
        'id' => 1,
        'titulo' => 'El Quijote',
        'paginas' => 412,
    ],
    [
        'id' => 2,
        'titulo' => 'El Hobbit',
        'paginas' => 328,
    ],
    [
        'id' => 3,
        'titulo' => 'El Señor de los Anillos',
        'paginas' => 1504,
    ]
];

$titulos = array_column(
    $libros,
    'titulo'
);

$indexado = array_column(
    $libros,
    null,
    'id'
);

print_r($titulos);
echo '<br>';
print_r($indexado);
