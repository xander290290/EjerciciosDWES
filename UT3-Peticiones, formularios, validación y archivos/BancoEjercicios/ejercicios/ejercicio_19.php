<?php

// Ejercicio 19: Recibir una portada y comprobar su estructura
$archivo = $_FILES['portada'] ?? null;
if (is_array($archivo)) {
    echo $archivo['error'] ?? 'sin error';
    echo ' | size=' . ($archivo['size'] ?? 'n/a');
    echo ' | tmp_name=' . ($archivo['tmp_name'] ?? 'n/a');
}
