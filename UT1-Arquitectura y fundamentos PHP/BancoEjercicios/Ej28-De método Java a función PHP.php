<?php

// static double calcularMulta(int dias, double precioDia) {
//     return dias * precioDia;
// }

function calcularMulta(int $dias, float $precioDia): float
{
    return $dias * $precioDia;
}

echo calcularMulta(5, 2.50);