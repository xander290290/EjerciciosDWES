<?php

date_default_timezone_set("Europe/Madrid");

$ahora = new DateTimeImmutable();

$devolucion = $ahora->modify("+15 days");

echo "Fecha actual: " . $ahora->format("d/m/Y H:i") . "<br>";
echo "Fecha de devolución: " . $devolucion->format("d/m/Y H:i");
