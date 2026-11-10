<?php
use function App\Soporte\e;
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Catálogo de la biblioteca</title></head>
<body>
<h1>Catálogo de la biblioteca</h1>
<p><a href="alta.php">Dar de alta un libro</a></p>
<!-- Bloque de errores proporcionado. Cada entrada identifica el campo y su mensaje. -->
<?php if ($errores !== []): ?>
    <ul role="alert">
        <?php foreach ($errores as $campo => $mensaje): ?>
            <li><?= e($campo) ?>: <?= e($mensaje) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<!-- COMPLETAR 1. Formulario GET con controles HTML estáticos. -->
<form method="GET" action="index.php">
    <label for="tituloAutor">Título o autor</label>
    <input type="text" name="tituloAutor" id="tituloAutor">
    <label for="genero">Género</label>
    <select name="genero" id="genero">
        <option value="">Todos</option>
        <option value="ciencia">Ciencia</option>
        <option value="fantasia">Fantasía</option>
        <option value="terror">Terror</option>
    </select>
    <button type="submit">Buscar</button>
</form>
<?php if ($errores === []): ?>
    <!-- COMPLETAR 3. Tabla de libros o mensaje si no hay coincidencias. -->
    <?php if ($libros !== []): ?>
        <table>
            <thead>
                <tr>
                    <td>Título</td>
                    <td>Autor</td>
                    <td>Páginas</td>
                    <td>Género</td>
                    <td>Fecha de alta</td>
                </tr>
            </thead>
            <tbody>
                <tr>
        <?php foreach($libros as $libro): ?>
                    <td><?php e($libro->titulo())?></td>
                    <td><?php e($libro->autor())?></td>
                    <td><?php e($libro->genero())?></td>
                    <td><?php e($libro->paginas())?></td>
                    <td><?php e(($libro->fechaAlta() ?? 'Sin fecha')->format("Y-m-d"))?></td>
        <?php endforeach; ?>
                </tr>
            </tbody>
        </table>
        <?php else: ?>
            <p>No hay títulos disponibles</p>
    <?php endif;?>
<?php endif; ?>
<p><a href="index.php">Limpiar filtros</a></p>
</body>
</html>
