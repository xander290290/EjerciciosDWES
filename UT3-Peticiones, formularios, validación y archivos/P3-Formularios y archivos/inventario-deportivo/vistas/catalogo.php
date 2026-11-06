<?php
use function App\Soporte\e;
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Catálogo del inventario</title></head>
<body>
<h1>Catálogo del inventario</h1>
<p><a href="alta.php">Dar de alta un material</a></p>
<!-- Bloque de errores proporcionado. Cada entrada identifica el campo y su mensaje. -->
<?php if ($errores !== []): ?>
    <ul role="alert">
        <?php foreach ($errores as $campo => $mensaje): ?>
            <li><?= e($campo) ?>: <?= e($mensaje) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<!-- COMPLETAR 1. Formulario GET con controles HTML estáticos. -->
<form method="post" action="index.php">
    <label for="q">Nombre o fabricante</label>
    <input type="text" id="q" name="q">
    <select name="categoria" id="categoria">
        <option value="">Todas</option>
        <option value="colectivo">Colectivo</option>
        <option value="raqueta">Raqueta</option>
        <option value="fitness">Fitness</option>
    </select>
    <button type="submit">Guardar</button>
</form>

<?php if ($errores === []): ?>
    <!-- COMPLETAR 3. Tabla de materiales o mensaje si no hay coincidencias. -->
    <?php if (!empty($materiales)): ?>
        <table>
            <thead>
                <tr>
                    <td>Nombre</td>
                    <td>Fabricante</td>
                    <td>Unidades</td>
                    <td>Categoría</td>
                    <td>Fecha de alta</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php if(!empty($errores)): ?>
                        <?php foreach($materiales as $material): ?>
                            <td><?php e($material->nombre())?></td>
                            <td><?php e($material->fabricante())?></td>
                            <td><?php e($material->unidades())?></td>
                            <td><?php e($material->categoria())?></td>
                            <td><?php e($material->fechaAlta()->format('Y-m-d')?? 'Sin fecha')?></td>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tr>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay materiales que coincidan</p>
    <?php endif; ?>
<?php endif; ?>
<p><a href="index.php">Limpiar filtros</a></p>
</body>
</html>
