<?php

$libro = [
    "id" => 1,
    "titulo" => "Libro de comedia",
    "autor" => "Pepe Pepe",
    "paginas" => 412,
    "disponible" => true
];

$libro["disponible"] = false;

foreach ($libro as $clave => $valor) {

    if (is_bool($valor)) {
        $valor = $valor ? "true" : "false";
    }

    echo $clave. ": " . $valor . "<br>";
} 