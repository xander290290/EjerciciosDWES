<?php

$codigo = 'LIB-2026-0042';
$tipo = substr($codigo, 0, 3);
$numero = substr($codigo, -4); //Extrae los caracteres indicados

$titulo = 'Drácula';
$inicio = mb_substr($titulo, 0, 3, 'UTF-8'); //Mantiene tildes y caracteres especiales

echo $tipo . '<br>';
echo $numero . '<br>';
echo $inicio;
