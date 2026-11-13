<?php

// Ejercicio 25: Servir la portada mediante una URL
$nombre = $_GET['nombre'] ?? '';
if (!is_string($nombre) || !preg_match('/\A[a-f0-9]{32}\.(jpg|png|webp)\z/', $nombre)) {
    http_response_code(404);
    exit;
}

$ruta = __DIR__ . '/../storage/portadas/' . $nombre;
if (!is_file($ruta)) {
    http_response_code(404);
    exit;
}
header('Content-Type: image/png');
header('X-Content-Type-Options: nosniff');
readfile($ruta);
