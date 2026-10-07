<?php

$texto = "Desarrollo Web con PHP";

$aparece = str_contains($texto, 'PHP'); //Devuelve booleano

$posicion = strpos($texto, 'PHP'); //Devuelve la posicion en la que aparece

echo 'Aparece?: ' . ($aparece ? 'true' : 'false') . '<br>';
echo ($aparece ? 'Posicion: ' . $posicion : 'No aparece');
