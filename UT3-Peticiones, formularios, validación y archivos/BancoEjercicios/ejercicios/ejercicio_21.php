<?php

// Ejercicio 21: Aplicar el límite y diagnosticar PHP
$limit = 2 * 1024 * 1024;
foreach ([0, 1, 2097152, 2097153] as $size) {
    $ok = $size >= 1 && $size <= $limit;
    echo $size . ' => ' . ($ok ? 'válido' : 'inválido') . PHP_EOL;
}
