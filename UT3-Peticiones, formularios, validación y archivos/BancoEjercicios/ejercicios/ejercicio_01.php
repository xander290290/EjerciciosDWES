<?php

// Ejercicio 1: Identificar los datos de una petición
$_GET = ['q' => 'Dune'];
$_SERVER['REQUEST_METHOD'] = 'GET';
$_POST = ['titulo' => 'Solaris'];

var_dump($_GET);
var_dump($_SERVER['REQUEST_METHOD']);
var_dump($_POST);
