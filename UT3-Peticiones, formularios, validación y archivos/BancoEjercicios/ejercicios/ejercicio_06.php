<?php

// Ejercicio 6: Validar título y autor
$errores = [];
$datos = ['titulo' => $_POST['titulo'] ?? '', 'autor' => $_POST['autor'] ?? ''];

foreach (['titulo', 'autor'] as $campo) {
    $valor = trim((string) $datos[$campo]);
    if ($valor === '') {
        $errores[$campo] = 'Campo obligatorio';
    } elseif (mb_strlen($valor, 'UTF-8') > 120 && $campo === 'titulo') {
        $errores[$campo] = 'Título demasiado largo';
    }
}

var_dump($datos, $errores);
