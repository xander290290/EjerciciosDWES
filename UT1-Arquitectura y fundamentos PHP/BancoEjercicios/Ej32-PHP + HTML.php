<?php

$titulos = [
    "Dune",
    "1984",
    "Fundación",
    "El Hobbit",
    "Los siete enanitos"
];

?>

<ul>
    <?php foreach ($titulos as $titulo): ?>
        <li><?= $titulo ?></li>
    <?php endforeach; ?>
</ul>