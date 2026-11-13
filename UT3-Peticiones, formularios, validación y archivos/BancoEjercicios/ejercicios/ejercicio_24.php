<?php

// Ejercicio 24: Mover solo una operación válida
$tmp = __DIR__ . '/../storage/portadas/tmp-upload.tmp';
$destino = __DIR__ . '/../storage/portadas/final.png';

if (is_file($tmp)) {
    $ok = move_uploaded_file($tmp, $destino);
    echo $ok ? 'movido' : 'fallo';
}
