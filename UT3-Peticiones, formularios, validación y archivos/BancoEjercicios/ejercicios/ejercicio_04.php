<?php

// Ejercicio 4: Buscar mediante GET
$q = $_GET['q'] ?? null;

if (!is_string($q)) {
    $mensaje = 'Entrada no válida';
} else {
    $q = trim($q);
    $mensaje = 'Filtro aplicado: ' . htmlspecialchars($q, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<form method="get" action="/libros.php">
    <input name="q" value="<?= htmlspecialchars($q ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
    <button type="submit">Buscar</button>
</form>
<p><?= $mensaje ?? '' ?></p>
