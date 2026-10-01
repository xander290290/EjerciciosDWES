<?php

$precio = 24.90;

$precioDescontado = $precio;
$precioDescontado *= 0.85;

$iva = $precioDescontado * 0.04;
$precioFinal = $precioDescontado + $iva;

echo "Precio descontado: $precioDescontado €" . PHP_EOL;
echo "IVA: " . round($iva, 2) . " €";
echo "Precio final: " . round($precioFinal, 2) . " €";
