<?php

declare(strict_types=1);

function diferenciaFechaAlta (array $libro) {
    $fechaAlta = new DateTimeImmutable($libro['fechaAlta']);
    $hoy = new DateTimeImmutable();

    $diferencia = $fechaAlta->diff($hoy);

    return "La diferencia desde la fecha de alta es de: " . $diferencia->d . " dias";
}

function buscarPorId(array $libros, int $id): ?array
{
    foreach ($libros as $libro) {
        if ($libro['id'] === $id) {
            return $libro;
        }
    }
    return null;
}

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

function filtrarDisponibles(array $libros): array
{
    $catalogoFiltrado = [];
    foreach ($libros as $libro) {
        if ($libro['disponible'] === true) {
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

function catalogo (array $libro) {
    echo "ID: " . $libro['id'] . "<br>";
    echo "Título: " . $libro['titulo'] . "<br>";
    echo "Autor: " . $libro['autor'] . "<br>";
    echo "Género: " . $libro['genero'] . "<br>";
    echo "Páginas: " . $libro['paginas'] . "<br>";
    echo "Disponible: " . ($libro['disponible'] ? 'Sí' : 'No') . "<br>";
    echo "Fecha de Alta: " . $libro['fechaAlta'] . "<br><br>";

    echo diferenciaFechaAlta($libro) . "<br><br>";
} // añadi esta funcion para no repetir el mismo echo con cada filtrado