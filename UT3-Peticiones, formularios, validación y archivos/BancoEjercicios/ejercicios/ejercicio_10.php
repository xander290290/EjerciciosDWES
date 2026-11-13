<?php

// Ejercicio 10: Tratar la fecha opcional
$raw = $_POST['fechaAlta'] ?? '';
$errores = [];

if (is_string($raw)) {
    $texto = trim($raw);
    if ($texto === '') {
        $fechaAlta = null;
    } else {
        $fecha = DateTimeImmutable::createFromFormat('!Y-m-d', $texto);
        if ($fecha === false || $fecha->format('Y-m-d') !== $texto) {
            $errores['fechaAlta'] = 'Fecha inválida';
        } else {
            $fechaAlta = $fecha;
        }
    }
} else {
    $errores['fechaAlta'] = 'Tipo no válido';
}

var_dump($fechaAlta ?? null, $errores);
