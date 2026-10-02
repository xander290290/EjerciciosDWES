<?php

require_once __DIR__ . '/../src/funciones.php';
require_once __DIR__ . '/../src/datos.php';

$genero = $_GET['genero'] ?? '';
$disponible = $_GET['disponible'] ?? '';

$libroMasLargo = obtenerLibroMasLargo($libros);

echo "<h1>Catálogo en PHP</h1>";
echo "<h2>Fecha de revision del catalogo</h2>";

$hoy = new DateTimeImmutable();
$fechaRevision = $hoy->modify("+30 days");

echo "<h2>Libro más largo:</h2>";
catalogo($libroMasLargo);

$catalogoFiltrado = $libros;

if ($disponible === 'si') {
    $catalogoFiltrado = filtrarDisponibles($catalogoFiltrado);
}

if ($genero !== '') {
    $catalogoFiltrado = filtrarPorGenero($catalogoFiltrado, $genero);
}

if ($genero !== '' || $disponible === 'si') {
    echo "Catálogo filtrado";

    if ($genero !== '') {
        echo " por género: " . $genero;
    }

    if ($disponible === 'si') {
        echo " y disponibilidad: Disponible";
    }

    echo "<br><br>";

    echo "Número de libros: " . count($catalogoFiltrado) . "<br><br>";
    echo "Media de páginas: " . calcularMediaPaginas($catalogoFiltrado) . "<br><br>";

    foreach ($catalogoFiltrado as $libro) {
        catalogo($libro);
        diferenciaFechaAlta($libro);
    }
} else {
    echo "<h2>Catálogo completo:</h2>";
    echo "Número de libros: " . count($libros) . "<br><br>";
    echo "Media de páginas: " . calcularMediaPaginas($libros) . "<br><br>";

    foreach ($libros as $libro) {
        catalogo($libro);
    }
}
