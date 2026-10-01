<?php

$codigo = "F";

switch ($codigo) {
    case "F":
        $resultado = "Fantasía";
        break;

    case "CF":
        $resultado = "Ciencia ficción";
        break;

    case "T":
        $resultado = "Terror";
        break;

    default:
        $resultado = "Desconocido";
}

echo $resultado;