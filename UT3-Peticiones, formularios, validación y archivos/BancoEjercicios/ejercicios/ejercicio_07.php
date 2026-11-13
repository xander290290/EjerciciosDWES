<?php

// Ejercicio 7: Validar páginas antes de convertir
$valor = $_POST['paginas'] ?? '';
$errores = [];

if (!is_string($valor)) {
    $errores['paginas'] = 'Tipo no válido';
} else {
    $valor = trim($valor);
    if ($valor === '') {
        $errores['paginas'] = 'Páginas obligatorias';
    } elseif (filter_var($valor, FILTER_VALIDATE_INT) === false) {
        $errores['paginas'] = 'Número no válido';
    } else {
        $paginas = (int) $valor;
        if ($paginas < 1 || $paginas > 3000) {
            $errores['paginas'] = 'Debe estar entre 1 y 3000';
        }
    }
}

var_dump($errores);
