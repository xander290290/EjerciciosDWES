<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use XanderAyala\Biblioteca\Servicio\BibliotecaService;

$libros = require dirname(__DIR__) . '/datos/libros.php';
$servicio = new BibliotecaService($libros);

$q = isset($_GET['q']) && is_string($_GET['q']) ? $_GET['q'] : '';
$genero = isset($_GET['genero']) && is_string($_GET['genero']) ? $_GET['genero'] : '';
$tipo = isset($_GET['tipo']) && is_string($_GET['tipo']) ? $_GET['tipo'] : '';
$soloDestacados = array_key_exists('destacados', $_GET);

$librosFiltrados = $servicio->filtrar($q, $genero, $tipo, $soloDestacados);
$filas = $servicio->filas($librosFiltrados);
$resumen = $servicio->resumen($librosFiltrados);

require dirname(__DIR__) . '/vistas/catalogo.php';
