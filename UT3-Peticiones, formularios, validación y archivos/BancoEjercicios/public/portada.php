<?php

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

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $ruta);
finfo_close($finfo);

if (!in_array($mime, ['image/jpeg', 'image/png', 'image/webp'], true)) {
    http_response_code(404);
    exit;
}

header('Content-Type: ' . $mime);
header('X-Content-Type-Options: nosniff');
readfile($ruta);
