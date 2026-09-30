<?php

$titulo = " El nombre del viento ";

$titulo = trim($titulo);

$longitud = strlen($titulo);

$contieneViento = str_contains($titulo, "viento");

$titulo = str_replace("viento", "fuego", $titulo);

$palabras = explode(" ", $titulo);

echo "Título:$titulo";
echo "<br>";
echo "Longitud: $longitud";
echo "<br>";
echo "Contiene viento: " . ($contieneViento ? "Sí" : "No");
echo "<br>";
foreach ($palabras as $palabra) {
    echo $palabra;
    echo "<br>";
}