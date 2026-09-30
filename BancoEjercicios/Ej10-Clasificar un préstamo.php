<?php

$diasRetraso = 12;

if ($diasRetraso === 0) {
    echo "Sin retraso";
} elseif ($diasRetraso >= 1 && $diasRetraso <= 7) {
    echo "Retraso leve";
} elseif ($diasRetraso >= 8 && $diasRetraso <= 30) {
    echo "Retraso grave";
} else {
    echo "Bloqueo temporal";
}