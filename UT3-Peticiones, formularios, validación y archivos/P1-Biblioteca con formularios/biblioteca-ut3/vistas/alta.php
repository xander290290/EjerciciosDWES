<?php
$escapar = static fn (mixed $valor): string => htmlspecialchars(
    (string) $valor,
    ENT_QUOTES | ENT_SUBSTITUTE,
    'UTF-8'
);
$errorCampo = static function (string $campo) use ($errores, $escapar): void {
    if (isset($errores[$campo])) {
        echo '<span>' . $escapar($errores[$campo]) . '</span>';
    }
};
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alta de libro</title>
    <link rel="stylesheet" href="style/estilos.css">
</head>
<body>
    <h1>Alta de libro</h1>

    <?php if ($ficha === null): ?>
        <?php if (isset($errores['general'])): ?>
            <p><?= $escapar($errores['general']) ?></p>
        <?php endif; ?>
        <form action="alta.php" method="post">
            <p>
                <label for="tipo">Tipo</label>
                <select id="tipo" name="tipo">
                    <option value="">Selecciona un tipo</option>
                    <option value="papel" <?= $valores['tipo'] === 'papel' ? 'selected' : '' ?>>Papel</option>
                    <option value="digital" <?= $valores['tipo'] === 'digital' ? 'selected' : '' ?>>Digital</option>
                </select>
                <?php $errorCampo('tipo'); ?>
            </p>
            <p>
                <label for="titulo">Título</label>
                <input type="text" id="titulo" name="titulo" value="<?= $escapar($valores['titulo']) ?>">
                <?php $errorCampo('titulo'); ?>
            </p>
            <p>
                <label for="autor">Autor</label>
                <input type="text" id="autor" name="autor" value="<?= $escapar($valores['autor']) ?>">
                <?php $errorCampo('autor'); ?>
            </p>
            <p>
                <label for="paginas">Páginas</label>
                <input type="text" id="paginas" name="paginas" value="<?= $escapar($valores['paginas']) ?>">
                <?php $errorCampo('paginas'); ?>
            </p>
            <p>
                <label for="genero">Género</label>
                <select id="genero" name="genero">
                    <option value="">Selecciona un género</option>
                    <option value="ciencia" <?= $valores['genero'] === 'ciencia' ? 'selected' : '' ?>>Ciencia</option>
                    <option value="fantasia" <?= $valores['genero'] === 'fantasia' ? 'selected' : '' ?>>Fantasía</option>
                    <option value="terror" <?= $valores['genero'] === 'terror' ? 'selected' : '' ?>>Terror</option>
                </select>
                <?php $errorCampo('genero'); ?>
            </p>
            <p>
                <label for="unidades">Ejemplares o licencias</label>
                <input type="text" id="unidades" name="unidades" value="<?= $escapar($valores['unidades']) ?>">
                <?php $errorCampo('unidades'); ?>
            </p>
            <p>
                <label for="fechaAlta">Fecha (YYYY-MM-DD)</label>
                <input type="text" id="fechaAlta" name="fechaAlta" value="<?= $escapar($valores['fechaAlta']) ?>">
                <?php $errorCampo('fechaAlta'); ?>
            </p>
            <p>
                <input type="checkbox" id="destacado" name="destacado" value="1" <?= $valores['destacado'] ? 'checked' : '' ?>>
                <label for="destacado">Destacado</label>
                <?php $errorCampo('destacado'); ?>
            </p>
            <p>
                <label for="observaciones">Observaciones</label>
                <textarea id="observaciones" name="observaciones"><?= $escapar($valores['observaciones']) ?></textarea>
                <?php $errorCampo('observaciones'); ?>
            </p>
            <p>
                <label for="correo">Correo</label>
                <input type="text" id="correo" name="correo" value="<?= $escapar($valores['correo']) ?>">
                <?php $errorCampo('correo'); ?>
            </p>
            <button type="submit">Dar de alta</button>
        </form>
    <?php else: ?>
        <h2>Libro dado de alta</h2>
        <p>Registrado por: <?= $escapar($valores['correo']) ?></p>
        <dl>
            <dt>Título</dt><dd><?= $escapar($ficha['titulo']) ?></dd>
            <dt>Autor</dt><dd><?= $escapar($ficha['autor']) ?></dd>
            <dt>Tipo</dt><dd><?= $ficha['tipo'] === 'papel' ? 'Papel' : 'Digital' ?></dd>
            <dt>Género</dt><dd><?= $escapar($ficha['genero']) ?></dd>
            <dt>Páginas</dt><dd><?= $escapar($ficha['paginas']) ?></dd>
            <dt>Unidades</dt><dd><?= $escapar($ficha['unidades']) ?></dd>
            <dt>Fecha</dt><dd><?= $escapar($ficha['fechaAlta']) ?></dd>
            <dt>Destacado</dt><dd><?= $ficha['destacado'] ? 'Sí' : 'No' ?></dd>
            <dt>Observaciones</dt><dd><?= $ficha['observaciones'] === '' ? 'Sin observaciones' : $escapar($ficha['observaciones']) ?></dd>
            <dt>Coste</dt><dd><?= number_format($ficha['costeCentimos'] / 100, 2, ',', '.') ?> €</dd>
        </dl>

        <h2>Catálogo actual</h2>
        <?php require __DIR__ . '/tabla.php'; ?>
    <?php endif; ?>

    <p><a href="index.php">Volver al catálogo</a></p>
</body>
</html>
