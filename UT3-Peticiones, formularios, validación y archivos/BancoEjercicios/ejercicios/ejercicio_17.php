<?php

// Ejercicio 17: Precargar una ficha de edición
require_once __DIR__ . '/../src/Model/LibroNoDisponibleException.php';
require_once __DIR__ . '/../src/Model/Libro.php';
require_once __DIR__ . '/../src/Repository/LibroRepository.php';
require_once __DIR__ . '/../src/Repository/ArrayLibroRepository.php';

use App\Model\Libro;
use App\Repository\ArrayLibroRepository;

$repo = new ArrayLibroRepository();
$repo->guardar(new Libro('Solaris', 'Stanislaw Lem', 240, 'ciencia', new DateTimeImmutable('2026-10-24')));

$id = $_GET['id'] ?? '3';
$libro = $repo->buscarPorId((int) $id);
if ($libro === null) {
    echo 'Libro no encontrado';
} else {
    echo $libro->titulo() . ' | ' . $libro->paginas() . ' | ' . $libro->fechaAlta()?->format('Y-m-d');
}
