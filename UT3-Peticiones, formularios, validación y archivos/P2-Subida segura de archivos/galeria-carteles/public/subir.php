<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/src/archivos.php';

if (!in_array($_SERVER['REQUEST_METHOD'] ?? 'GET', ['GET', 'POST'], true)) {
    http_response_code(405);
    header('Allow: GET, POST');
    exit;
}

$anterior = null;
if (array_key_exists('anterior', $_GET)) {
    $anterior = inspeccionarCartel($_GET['anterior']);
    if ($anterior === null) {
        http_response_code(404);
        exit;
    }
}

$errores = [];
$mensaje = null;
$imagenGuardada = null;

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    if (excedeLimitePost()) {
        $errores[] = 'El envío supera el límite de recepción de 8 MiB.';
    } else {
        $recepcion = recibirImagen($_FILES);
        if ($recepcion['error'] !== null) {
            $errores[] = $recepcion['error'];
        } elseif ($recepcion['sinArchivo']) {
            if ($anterior !== null) {
                $mensaje = 'No se ha cambiado el cartel.';
            } else {
                $errores[] = 'Selecciona una imagen para el cartel.';
            }
        } else {
            $revision = inspeccionarImagen($recepcion['archivo']);
            if ($revision['error'] !== null) {
                $errores[] = $revision['error'];
            } else {
                $esSustitucion = $anterior !== null;
                $guardado = guardarImagen($revision['archivo'], $anterior['nombre'] ?? null);
                if ($guardado['error'] !== null) {
                    $errores[] = $guardado['error'];
                } elseif ($anterior !== null && !unlink($anterior['ruta'])) {
                    $nuevo = $guardado['cartel'];
                    if (!unlink($nuevo['ruta'])) {
                        error_log('No se pudo eliminar el cartel nuevo ' . $nuevo['nombre'] . ' tras fallar la sustitución.');
                        $errores[] = 'No se pudo retirar el cartel anterior ni limpiar la imagen nueva. La operación no se completó.';
                    } else {
                        $errores[] = 'No se pudo retirar el cartel anterior. Se ha conservado el cartel original y descartado el nuevo.';
                    }
                } else {
                    $actualizado = $guardado['cartel'];
                    $imagenGuardada = [
                        'nombre' => $actualizado['nombre'],
                        'ruta' => $actualizado['ruta'],
                        'mime' => $revision['archivo']['mime'],
                    ];
                    $mensaje = $esSustitucion
                        ? 'Cartel sustituido correctamente.'
                        : 'Cartel guardado correctamente.';
                }
            }
        }
    }
}

$action = 'subir.php';
if ($anterior !== null) {
    $action .= '?anterior=' . rawurlencode($anterior['nombre']);
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $anterior === null ? 'Subir cartel' : 'Sustituir cartel' ?></title>
</head>
<body>
    <h1><?= $anterior === null ? 'Subir cartel' : 'Sustituir cartel' ?></h1>

    <?php if ($anterior !== null && $imagenGuardada === null): ?>
        <p>Cartel actual:</p>
        <img src="imagen.php?nombre=<?= escapar(rawurlencode($anterior['nombre'])) ?>"
             alt="Cartel actual <?= escapar($anterior['nombre']) ?>">
    <?php endif; ?>

    <?php if ($mensaje !== null): ?>
        <p role="status"><?= escapar($mensaje) ?></p>
        <?php if ($imagenGuardada !== null): ?>
            <img src="imagen.php?nombre=<?= escapar(rawurlencode($imagenGuardada['nombre'])) ?>"
                 alt="Cartel guardado <?= escapar($imagenGuardada['nombre']) ?>">
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($imagenGuardada === null): ?>
        <form method="post" action="<?= escapar($action) ?>" enctype="multipart/form-data">
            <label for="imagen">Imagen (JPEG, PNG o WebP)</label>
            <input type="file" id="imagen" name="imagen" accept="image/jpeg,image/png,image/webp">
            <?php foreach ($errores as $error): ?>
                <p role="alert"><?= escapar($error) ?></p>
            <?php endforeach; ?>
            <button type="submit">Guardar</button>
        </form>
    <?php endif; ?>

    <p><a href="index.php">Volver a la galería</a></p>
</body>
</html>
