<?php

// Ejercicio 5: Separar normalización y escape
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$titulo = ' <Dune> & "edición" ';
$guardado = trim($titulo);
?>
<p><?= e($guardado) ?></p>
<input type="text" value="<?= e($guardado) ?>">
