<?php

$generos = ['terror','fantasia','comedia','comedia','terror','comedia'];

$generosUnicos = array_unique($generos); //Elimina duplicados

$claves = ['tr','fa','co'];

$arrayCombinado = array_combine($claves, $generosUnicos); //Combina las claves y valores

print_r($arrayCombinado); //Ambos arrays deben tener la misma cantidad de elementos, si no, devuelve false