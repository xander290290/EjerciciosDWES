<?php

// Ejercicio 13: LibroFormService
require_once __DIR__ . '/../src/Validator.php';
require_once __DIR__ . '/../src/LibroFormService.php';

use App\LibroFormService;
use App\Validator;

$service = new LibroFormService(new Validator());
$resultado = $service->procesar([
    'titulo' => ' Dune ',
    'autor' => 'Frank Herbert',
    'paginas' => '412',
    'genero' => 'ciencia',
    'fechaAlta' => '',
]);

var_dump($resultado);
