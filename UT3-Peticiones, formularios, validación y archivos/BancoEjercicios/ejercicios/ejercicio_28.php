<?php

// Ejercicio 28: Integrar el formulario y la portada
require_once __DIR__ . '/../src/Validator.php';
require_once __DIR__ . '/../src/LibroFormService.php';

use App\LibroFormService;
use App\Validator;

$service = new LibroFormService(new Validator());
$result = $service->procesar($_POST);

var_dump($result);
