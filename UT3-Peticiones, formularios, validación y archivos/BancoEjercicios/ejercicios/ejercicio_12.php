<?php

// Ejercicio 12: Extraer una regla reutilizable
require_once __DIR__ . '/../src/Validator.php';

use App\Validator;

$validator = new Validator();
$errores = [];
foreach (['Dune', '', '   ', "	"] as $titulo) {
    $r = $validator->requerido($titulo, 'Título obligatorio');
    $errores[] = [$titulo => $r];
}
var_dump($errores);
