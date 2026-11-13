<?php

// Ejercicio 20: Distinguir ausencia y error de recepción
$archivo = [
    'error' => UPLOAD_ERR_OK,
    'size' => 123,
    'tmp_name' => '/tmp/subida.tmp',
];

if (!array_key_exists('portada', $_FILES)) {
    echo 'Sin archivo';
} elseif ($archivo['error'] === UPLOAD_ERR_NO_FILE) {
    echo 'Sin selección';
} elseif ($archivo['error'] === UPLOAD_ERR_OK) {
    echo 'Archivo listo';
} elseif ($archivo['error'] === UPLOAD_ERR_INI_SIZE) {
    echo 'Muy grande';
} elseif ($archivo['error'] === UPLOAD_ERR_PARTIAL) {
    echo 'Parcial';
} else {
    echo 'Error no especificado';
}
