<?php

// Ejercicio 23: Generar un nombre y un destino controlados
$ext = 'png';
$nombre = bin2hex(random_bytes(16)) . '.' . $ext;
$destino = __DIR__ . '/../storage/portadas/' . $nombre;

if (!is_dir(__DIR__ . '/../storage/portadas') || !is_writable(__DIR__ . '/../storage/portadas')) {
    throw new RuntimeException('Directorio no escribible');
}

if (file_exists($destino)) {
    throw new RuntimeException('Nombre ya ocupado');
}

echo $nombre . PHP_EOL;
