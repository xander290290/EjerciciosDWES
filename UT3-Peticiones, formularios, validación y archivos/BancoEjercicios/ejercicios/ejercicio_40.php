<?php

// Ejercicio 40: Regla pura de portada y pruebas de integración
function validarPortada(int $bytes, string $mime): ?string
{
    if ($bytes < 1 || $bytes > 2 * 1024 * 1024) {
        return 'Tamaño no válido';
    }
    if ($mime !== 'image/png') {
        return 'MIME no válido';
    }
    return null;
}

foreach ([1, 2 * 1024 * 1024, 2 * 1024 * 1024 + 1] as $bytes) {
    $msg = validarPortada($bytes, 'image/png');
    echo $bytes . ' => ' . ($msg === null ? 'válido' : $msg) . PHP_EOL;
}
