<?php

// Ejercicio 3: Leer POST sin errores de tipo
function normalizarTitulo(mixed $valor): array
{
    $titulo = '';
    $errores = [];

    if ($_SERVER['REQUEST_METHOD'] ?? '' !== 'POST') {
        return ['titulo' => $titulo, 'errores' => $errores];
    }

    if (!isset($_POST['titulo']) || !is_string($_POST['titulo'])) {
        $errores['titulo'] = 'Tipo no válido';
        return ['titulo' => '', 'errores' => $errores];
    }

    $titulo = trim($_POST['titulo']);
    return ['titulo' => $titulo, 'errores' => $errores];
}

$vista = normalizarTitulo($_POST['titulo'] ?? null);
var_dump($vista);
