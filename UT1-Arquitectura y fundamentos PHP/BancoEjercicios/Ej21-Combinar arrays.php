<?php

$novedades1 = [
    "Dune",
    "1984",
    "Fundación"
];

$novedades2 = [
    "El Hobbit",
    "Neuromante",
    "Solaris"
];

$novedades = array_merge($novedades1, $novedades2);

unset($novedades[1]);

$novedades = array_values($novedades);

foreach ($novedades as $indice => $titulo) {
    echo "$indice: $titulo" . "<br>";
}