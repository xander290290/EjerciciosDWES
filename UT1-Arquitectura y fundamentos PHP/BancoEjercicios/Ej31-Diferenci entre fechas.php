<?php

$fecha1 = new DateTimeImmutable("2026-09-01");
$fecha2 = new DateTimeImmutable("2026-10-18");

$diferencia = $fecha1->diff($fecha2);

echo "Hay " . $diferencia->m . " días de diferencia.";
