<?php

$paginas = [];

$mas1000 = array_any(
    $libros,
    fn (array $l): bool => $l['paginas'] === 1000
);

echo $mas1000;