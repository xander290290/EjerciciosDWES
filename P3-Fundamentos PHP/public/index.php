<?php

const retrasoLeve = 4;
const retrasoGrave = 8;

$tipo = $_GET['tipo'] ?? 'externo';
$dias = $_GET['dias'] ?? '0';
$renovacion = $_GET['renovacion'] ?? 'no';

$diasInt = (int) $dias;

$maxDiasPrestamo = match ($tipo) {
    'alumno' => 15,
    'profesor' => 30,
    'externo' => 7
};

if ($renovacion === 'si' && $tipo !== 'externo') {
    $maxDiasPrestamo += 7;
}

$retraso = max(0, $diasInt - $maxDiasPrestamo);

if ($retraso === 0) {
    $situacion = 'correcta';
} elseif ($retraso <= retrasoLeve) {
    $situacion = 'retraso leve';
} else {
    $situacion = 'retraso grave';
}

$deuda = $retraso * 0.50;

$escTipo = htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8');
$escRenovacion = htmlspecialchars($renovacion, ENT_QUOTES, 'UTF-8');

echo "Usuario de tipo $escTipo con días de préstamo $diasInt en situación de $situacion, tiene una deuda de $deuda € <br><br>";

if ($retraso === 0) {
    echo "No hay dias de retraso.<br>";
} else {
    for ($i = 1; $i <= $retraso; $i++) {
        echo "Día de retraso: $i<br>";
        if ($i === 10){
            echo "...<br>";
            break;
        }
    }
}