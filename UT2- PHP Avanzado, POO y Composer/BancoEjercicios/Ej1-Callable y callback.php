<?php

function aplicar(int $n, callable $callback): int {
    return $callback($n);
}

function doble(int $n) {
    return $n * 2;
}

function cuadrado(int $n){
    return $n * 4;
}

$res = aplicar(4, 'doble');

echo "$res";