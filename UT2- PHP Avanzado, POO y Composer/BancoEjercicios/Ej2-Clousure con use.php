<?php

$iva = 0.5;

$f = function (int $precio) use ($iva): float {
    return $precio * (1 + $iva);
};

$total = $f(100,0);

echo $total;