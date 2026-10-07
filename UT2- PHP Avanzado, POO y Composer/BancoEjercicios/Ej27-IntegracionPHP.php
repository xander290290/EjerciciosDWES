<?php

$libros = [
 ['id' => 1, 'titulo' => 'Dune', 'paginas' => 412],
 ['id' => 2, 'titulo' => 'It', 'paginas' => 1504],
];

$busqueda = mb_strtolower('du', 'UTF-8'); //Normaliza convervando caracteres especiales

$visibles = array_filter(
 $libros, fn (array $l): bool => str_contains(
 mb_strtolower($l['titulo'], 'UTF-8'), $busqueda //Filtra por titulos buscando si contienen la cadena de busqueda
 )
);

usort($libros, fn (array $a, array $b): int => $a['paginas'] <=> $b['paginas']); //Ordena los libros de menor a mayor por páginas

$titulos = array_column($libros, 'titulo'); //Extrae los valores de la columna título
$etiquetas = array_map(fn (string $t): string => "Libro: $t", $titulos); //Añade etiqueta Libro: a cada titulo

$libro2 = array_find($libros, fn (array $l): bool => $l['id'] === 2); //Busca el primer libro que concida con id = 2;
