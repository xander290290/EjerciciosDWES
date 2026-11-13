<?php

// Ejercicio 14: Contrato del servicio
require_once __DIR__ . '/../src/Validator.php';
require_once __DIR__ . '/../src/LibroFormService.php';

use App\LibroFormService;
use App\Validator;

$service = new LibroFormService(new Validator());
$r = $service->procesar(['titulo' => ' Dune ', 'autor' => 'Frank Herbert', 'paginas' => '412', 'genero' => 'ciencia', 'fechaAlta' => '']);
var_dump($r['valores']['paginas'], $r['datos']['paginas'], $r['datos']['titulo'], $r['errores']);
