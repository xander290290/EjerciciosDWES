<?php

declare(strict_types=1);

REQUIRE_ONCE __DIR__ . '/../src/funciones.php';
REQUIRE_ONCE __DIR__ . '/../src/datos.php';

echo "Número total de libros: " . count($catalogo) . '<br>';

$disponibles = filtrarPorDisponibilidad($catalogo);

echo "Número de libros disponibles: " . count($disponibles) . '<br>';

echo "Media de páginas: " . calcularMediaPaginas($catalogo) . '<br>';

echo "El libro con más páginas es: " . obtenerLibroMasLargo($catalogo) . '<br>';

$cienciaFiccion = contadorGeneros($catalogo, 'ciencia ficcion');
$terror = contadorGeneros($catalogo, 'terror');
$distopia = contadorGeneros($catalogo, 'distopia');
$fantasia = contadorGeneros($catalogo, 'fantasia');

echo "En el genero de Ciencia ficcion hay " . count($cienciaFiccion) . '<br>';
echo "En el genero de Terror hay " . count($terror) . '<br>';
echo "En el genero de Distopia hay " . count($distopia) . '<br>';
echo "En el genero de Fantasia hay " . count($fantasia) . '<br>';

echo date('d/m/Y H:i', $timestamp);





