<?php

function duplicarValor($n) {
    $n *= 2;
}

function duplicarReferencia(&$n) {
    $n *= 2;
}

$a = 5;
$b = 5;

duplicarValor($a); //Por valor solo modifica la variable interna de la función
duplicarReferencia($b); //Por referencia modifica la variable que se le pasa por argumento

echo "$a - $b";