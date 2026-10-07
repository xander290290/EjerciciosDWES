<?php

$persona = [
    'titulo' => 'Don quijote',
    'autor' => 'Miguel de Cervantes',
];

['titulo' => $t, 'autor' => $a] = $persona;

echo $t . PHP_EOL;
echo $a;