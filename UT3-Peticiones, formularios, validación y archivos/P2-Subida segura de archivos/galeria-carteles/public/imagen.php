<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/src/archivos.php';

$cartel = inspeccionarCartel($_GET['nombre'] ?? null);
if ($cartel === null) {
    http_response_code(404);
    exit;
}

header('Content-Type: ' . $cartel['mime']);
header('X-Content-Type-Options: nosniff');

if (readfile($cartel['ruta']) === false) {
    error_log('No se pudo leer el cartel ' . $cartel['nombre'] . ' para responder a la petición.');
}
exit;
