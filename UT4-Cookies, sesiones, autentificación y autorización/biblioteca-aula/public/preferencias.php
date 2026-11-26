<?php

declare(strict_types=1);

# Guardar las preferencias de la página
$app = require dirname(__DIR__) . '/config/inicio.php';
(new App\Controlador\PreferenciasControlador($app))->guardar();