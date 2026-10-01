<?php

require_once __DIR__ . '/../src/funciones.php';
require_once __DIR__ . '/../src/datos.php';

$genero = $_GET['genero'] ?? '';
$disponible = $_GET['disponible'] ?? '';

$libroMasLargo = obtenerLibroMasLargo($libros);

echo "<h1>Catálogo en PHP</h1>";
echo "<h2>Libro más largo:</h2>";
catalogo($libroMasLargo);


if ($genero !== '' && $disponible === '1') { 
    $catalogoFiltrado = filtrarDisponibles($libros);
    $catalogoFiltradoFinal = filtrarPorGenero($catalogoFiltrado, $genero);
    echo "Catálogo filtrado por género: " . $genero . " y disponibilidad: " . ($disponible ? 'Disponible' : 'No disponible') . "<br><br>";
    echo "Numero de libros: " . count($catalogoFiltradoFinal)."<br><br>";
    echo "Media de páginas: " . calcularMediaPaginas($catalogoFiltradoFinal)."<br><br>";
    foreach ($catalogoFiltradoFinal as $libro) {
        catalogo($libro);
    }
} elseif ($genero !== '') {
    $catalogoFiltrado = filtrarPorGenero($libros, $genero);
    echo "Catálogo filtrado por género: " . $genero . "<br><br>";
    echo "Numero de libros: " . count($catalogoFiltrado)."<br><br>";
    echo "Media de páginas: " . calcularMediaPaginas($catalogoFiltrado)."<br><br>";
    foreach ($catalogoFiltrado as $libro) {
        catalogo($libro);
    }
} elseif ($disponible === '1') {
    $catalogoFiltrado = filtrarDisponibles($libros);
    echo "Catálogo filtrado por disponibilidad: <br><br>";
    echo "Numero de libros: " . count($catalogoFiltrado)."<br><br>";
    echo "Media de páginas: " . calcularMediaPaginas($catalogoFiltrado)."<br><br>";
    foreach ($catalogoFiltrado as $libro) {
        catalogo($libro);
    }
} else {
    echo "Catálogo completo: <br><br>";
    echo "Numero de libros: " . count($libros)."<br><br>";
    echo "Media de páginas: " . calcularMediaPaginas($libros)."<br><br>";
    foreach ($libros as $libro) {
        catalogo($libro);
    }
}

