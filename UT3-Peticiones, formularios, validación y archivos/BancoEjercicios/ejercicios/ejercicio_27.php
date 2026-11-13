<?php

// Ejercicio 27: Validar varias portadas
$portadas = $_FILES['portadas'] ?? [];
if (!is_array($portadas)) {
    echo 'Formato inválido';
    exit;
}

if (count($portadas['name'] ?? []) > 3) {
    echo 'Máximo 3 portadas';
} else {
    echo 'Se valida cada archivo';
}
