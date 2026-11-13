<?php

// Ejercicio 18: Editar sin perder datos ni estado
require_once __DIR__ . '/../src/Model/LibroNoDisponibleException.php';
require_once __DIR__ . '/../src/Model/Libro.php';
require_once __DIR__ . '/../src/Repository/LibroRepository.php';
require_once __DIR__ . '/../src/Repository/ArrayLibroRepository.php';

use App\Model\Libro;
use App\Repository\ArrayLibroRepository;

$repo = new ArrayLibroRepository();
$libro = new Libro('Solaris', 'Stanislaw Lem', 240, 'ciencia', new DateTimeImmutable('2026-10-24'));
$libro->prestar();
$libro->cambiarPortada('portada.jpg');
$id = $repo->guardar($libro);

$libroDesdeRepo = $repo->buscarPorId($id);
var_dump($libroDesdeRepo->disponible(), $libroDesdeRepo->portada());
