<?php

$generos = [
    "Fantasía",
    "Ciencia ficción",
    "Terror",
    "Misterio",
    "Romance"
];

$generos[] = "Aventura";

$generos[2] = "Comedia";

unset($generos[0]);

foreach ($generos as $genero) {
    echo $genero . "<br>";
}