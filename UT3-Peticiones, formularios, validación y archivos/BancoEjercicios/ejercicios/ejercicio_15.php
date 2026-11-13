<?php

// Ejercicio 15: Completar el modelo y repositorio
require_once __DIR__ . '/../src/Model/LibroNoDisponibleException.php';
require_once __DIR__ . '/../src/Model/Libro.php';
require_once __DIR__ . '/../src/Repository/LibroRepository.php';
require_once __DIR__ . '/../src/Repository/ArrayLibroRepository.php';

use App\Model\Libro;
use App\Repository\ArrayLibroRepository;

$repo = new ArrayLibroRepository();
$libro = new Libro('Dune', 'Frank Herbert', 412, 'ciencia');
$id = $repo->guardar($libro);
var_dump($id, $repo->buscarPorId($id)->titulo());
