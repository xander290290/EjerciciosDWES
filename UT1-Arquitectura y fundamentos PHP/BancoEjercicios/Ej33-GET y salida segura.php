<?php

$q = $_GET["q"] ?? "";

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Búsqueda</title>
</head>
<body>

<p>
    Buscando: <?= htmlspecialchars($q, ENT_QUOTES, 'UTF-8') ?>
</p>

</body>
</html>