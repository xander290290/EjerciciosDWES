<?php

function nombreCompleto(string $apellido, string $nombre): string 
{
    return $nombre." ".$apellido;
}

$nombre = 'Juan';
$apellido = 'martinez';

echo nombreCompleto(nombre: $nombre, apellido: $apellido);