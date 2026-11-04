<?php

declare(strict_types=1);

$escapar = static fn (mixed $valor): string => htmlspecialchars(
    (string) $valor,
    ENT_QUOTES | ENT_SUBSTITUTE,
    'UTF-8'
);
?>
<table>
    <thead>
        <tr>
            <th>Título</th>
            <th>Autor</th>
            <th>Género</th>
            <th>Tipo</th>
            <th>Páginas</th>
            <th>Unidades</th>
            <th>Coste de reposición</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($filas === []): ?>
            <tr>
                <td colspan="7">No hay libros que coincidan.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($filas as $fila): ?>
                <tr>
                    <td><?= $escapar($fila['titulo']) ?></td>
                    <td><?= $escapar($fila['autor']) ?></td>
                    <td><?= $escapar($fila['genero']) ?></td>
                    <td><?= $fila['tipo'] === 'papel' ? 'Papel' : 'Digital' ?></td>
                    <td><?= $escapar($fila['paginas']) ?></td>
                    <td><?= $escapar($fila['unidades']) ?></td>
                    <td><?= number_format($fila['costeCentimos'] / 100, 2, ',', '.') ?> €</td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<p>Número de títulos: <?= $escapar($resumen['titulos']) ?></p>
<p>Unidades: <?= $escapar($resumen['unidades']) ?></p>
<p>Páginas: <?= $escapar($resumen['paginas']) ?></p>
<p>Coste total: <?= number_format($resumen['costeCentimos'] / 100, 2, ',', '.') ?> €</p>
