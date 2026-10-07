<?php

function mostrarMixed (mixed $valor): string 
{
    if (is_bool($valor)) {
        return $valor ?"true":"false";
    }
    return (string) $valor;
}

echo (mostrarMixed(true)) . PHP_EOL;
var_dump (mostrarMixed(23)) . PHP_EOL;