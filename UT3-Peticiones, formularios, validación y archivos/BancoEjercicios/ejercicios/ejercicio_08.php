<?php

// Ejercicio 8: Recuperar una lista y una casilla
$generos = ['ciencia', 'fantasia', 'terror'];
$genero = $_POST['genero'] ?? '';
$destacado = $_POST['destacado'] ?? null;
$observaciones = $_POST['observaciones'] ?? '';

$destacado = ($destacado === '1');
$observaciones = is_string($observaciones) ? trim($observaciones) : '';

var_dump($generos, $genero, $destacado, $observaciones);
