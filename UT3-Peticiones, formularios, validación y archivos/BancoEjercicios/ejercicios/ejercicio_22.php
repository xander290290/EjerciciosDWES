<?php

// Ejercicio 22: Decidir el formato por el contenido
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$archivo = __DIR__ . '/../storage/portadas/ejemplo.png';
$mime = finfo_file($finfo, $archivo);
if ($mime === false) {
    echo 'MIME no detectado';
} else {
    echo $mime;
}
