<?php

// Ejercicio 11: Completar un formulario de dos campos
$errores = [];
$valores = ['titulo' => '', 'paginas' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $paginas = $_POST['paginas'] ?? '';

    if (!is_string($titulo)) {
        $errores['titulo'] = 'Tipo no válido';
    } else {
        $valores['titulo'] = trim($titulo);
        if ($valores['titulo'] === '') {
            $errores['titulo'] = 'Título obligatorio';
        }
    }

    if (!is_string($paginas)) {
        $errores['paginas'] = 'Tipo no válido';
    } else {
        $valores['paginas'] = trim($paginas);
        if (filter_var($valores['paginas'], FILTER_VALIDATE_INT) === false) {
            $errores['paginas'] = 'Páginas no válidas';
        }
    }
}
?>
<form method="post">
    <input name="titulo" value="<?= htmlspecialchars($valores['titulo'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
    <input name="paginas" value="<?= htmlspecialchars($valores['paginas'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
    <button type="submit">Enviar</button>
</form>
<?php if ($errores): foreach ($errores as $k => $v): ?>
    <p><?= htmlspecialchars($k . ': ' . $v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
<?php endforeach; endif; ?>
