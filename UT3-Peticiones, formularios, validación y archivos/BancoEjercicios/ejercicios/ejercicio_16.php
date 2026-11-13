<?php

// Ejercicio 16: Dar de alta y responder con PRG
require_once __DIR__ . '/../src/Validator.php';
require_once __DIR__ . '/../src/LibroFormService.php';
require_once __DIR__ . '/../src/Model/LibroNoDisponibleException.php';
require_once __DIR__ . '/../src/Model/Libro.php';
require_once __DIR__ . '/../src/Repository/LibroRepository.php';
require_once __DIR__ . '/../src/Repository/ArrayLibroRepository.php';

use App\LibroFormService;
use App\Repository\ArrayLibroRepository;
use App\Validator;

$repo = new ArrayLibroRepository();
$service = new LibroFormService(new Validator());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resultado = $service->procesar($_POST);
    if ($resultado['errores'] === []) {
        $libro = new App\Model\Libro($resultado['datos']['titulo'], $resultado['datos']['autor'], $resultado['datos']['paginas'], $resultado['datos']['genero'], $resultado['datos']['fechaAlta']);
        $repo->guardar($libro);
        header('Location: /resultado.php?ok=1', true, 303);
        exit;
    }
}
