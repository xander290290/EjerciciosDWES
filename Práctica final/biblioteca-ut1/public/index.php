<?php

declare(strict_types=1);

REQUIRE_ONCE __DIR__ . '/../src/funciones.php';
REQUIRE_ONCE __DIR__ . '/../src/datos.php';

$genero = $_GET['genero'] ?? '';
$disponibilidad = $_GET['disponibilidad'] ?? '';
$autor = $_GET['autor'] ?? '';
$titulo = $_GET['titulo'] ?? '';

$escGenero = htmlspecialchars($genero, ENT_QUOTES, 'UTF-8');
$escDisponibilidad = htmlspecialchars($disponibilidad, ENT_QUOTES, 'UTF-8');
$escAutor = htmlspecialchars($autor, ENT_QUOTES, 'UTF-8');
$escTitulo = htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8');


echo "<h1>Catálogo Final</h1><br>";

if ($genero !== ''){
    $newColection = filtrarPorGenero($catalogo, $genero);
    echo "Libros filtrados por género<br><br>";
    echo "Número de libros: " . count($newColection).'<br><br>';
    foreach ($newColection as $libro){
        mostrar($libro);
    }
} elseif ($disponibilidad !== ''){
    $newColection = filtrarPorDisponibilidad($catalogo);
    echo "Libros filtrados por disponibilidad<br><br>";
    echo "Número de libros: " . count($newColection).'<br><br>';
    foreach ($newColection as $libro){
        mostrar($libro);
    }
} else {
    echo "Todos los libros<br><br>";
    echo "Número de libros: " . count($catalogo).'<br><br>';
    foreach ($catalogo as $libro){
        mostrar($libro);
    }
}