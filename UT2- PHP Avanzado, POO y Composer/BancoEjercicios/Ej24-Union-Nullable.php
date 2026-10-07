<?php

function normalizarId(int|string $id): int
{
    return (int) $id;
}

function etiqueta (?string $titulo): string
{
    return ($titulo) ? $titulo : 'Sin título';        
}

var_dump(normalizarId('23')) . PHP_EOL;
echo etiqueta(null);
