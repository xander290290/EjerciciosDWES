<?php

declare(strict_types=1);

function filtrarPorGenero(array $libros, string $genero): array
{
    $catalogoFiltrado = [];
    foreach ($libros as $libro) {
        if ($libro['genero'] === $genero) {
            $catalogoFiltrado[] = $libro;
        }
    }
    return $catalogoFiltrado;
}

function filtrarPorDisponibilidad(array $libros): ?array
{
    $catalogoFiltrado = [];
    foreach ($libros as $libro) {
        if ($libro['disponible'] === true){
            $catalogoFiltrado[] = $libro;
        }
    }
    return $catalogoFiltrado;
}

function calcularMediaPaginas(array $libros): float
{
    $total = 0;
    $numColeccionLibros = count($libros);

    $numLibros = (float) $numColeccionLibros;

    foreach ($libros as $libro) {
        $total += $libro['paginas'];
    }

    return round($total / $numLibros, 2);
}

function obtenerLibroMasLargo(array $libros): ?array
{
    $libroMasLargo = $libros[0];

    foreach ($libros as $libro) {
        if ($libro['paginas'] > $libroMasLargo['paginas']) {
            $libroMasLargo = $libro;
        }
    }

    return $libroMasLargo;
}

function busquedaPorId (array $libros, int $id): ?array
{
    foreach ($libros as $libro){
        if ($libro['id' === $id]){
            return $libro;
        }
    }
    return null;
}

function contadorGeneros (array $libros, string $genero): array
{
    $array = [];
    foreach ($libros as $libro){
        if ($libro['genero'] === $genero){
            $array[] = $libro;
        }
    }
    return $array;
}

function ordenarPaginas (array $libros) {
    $ordenPag = [];
    foreach ($libros as $libro){
        if ($libro[paginas] > $ordenPag){
            $libro = $ordenPag;
        }
    }
    return $ordenPag;
}

function mostrar (array $libro) {
    echo "ID: " . $libro['id'] . "<br>";
    echo "Título: " . $libro['titulo'] . "<br>";
    echo "Autor: " . $libro['autor'] . "<br>";
    echo "Género: " . $libro['genero'] . "<br>";
    echo "Páginas: " . $libro['paginas'] . "<br>";
    echo "Disponible: " . ($libro['disponible'] ? 'Sí' : 'No') . "<br>";
    echo "Fecha de Alta: " . $libro['fechaAlta'] . "<br><br>";
}