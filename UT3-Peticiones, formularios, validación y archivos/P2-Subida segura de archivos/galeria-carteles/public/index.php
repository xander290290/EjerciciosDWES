<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/src/archivos.php';

$carteles = listarCarteles();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Galería de carteles</title>
</head>
<body>
    <h1>Galería de carteles</h1>
    <p><a href="subir.php">Subir cartel</a></p>

    <?php if ($carteles === false): ?>
        <p role="alert">No se pudo consultar la galería.</p>
    <?php elseif ($carteles === []): ?>
        <p>Todavía no hay carteles</p>
    <?php else: ?>
        <ul>
            <?php foreach ($carteles as $cartel): ?>
                <li>
                    <img src="imagen.php?nombre=<?= escapar(rawurlencode($cartel['nombre'])) ?>"
                         alt="Cartel <?= escapar($cartel['nombre']) ?>">
                    <p><?= escapar($cartel['nombre']) ?></p>
                    <a href="subir.php?anterior=<?= escapar(rawurlencode($cartel['nombre'])) ?>">Sustituir</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
