<?php

require_once __DIR__ . '/./Ej17-Catalogo multidimensional.php';

$contador = 0;

foreach ($catalogo as $libro) {

    if ($libro["disponible"] === true && $libro["paginas"] < 500) {
        echo $libro["titulo"] . "<br>";
        $contador++;
    }
}

echo "Total: $contador";