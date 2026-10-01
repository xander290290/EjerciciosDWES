<?php

$titulos = [
    "Dune",
    "1984",
    "Fundación",
    "El Hobbit"
];

?>

<ul>
    <?php foreach ($titulos as $titulo): ?>
        <li><?= $titulo ?></li>
    <?php endforeach; ?>
</ul>