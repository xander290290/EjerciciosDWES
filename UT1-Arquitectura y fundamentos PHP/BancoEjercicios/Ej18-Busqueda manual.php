<?php

require_once __DIR__ . '/./Ej17-Catalogo multidimensional.php';

foreach ($catalogo as $libro) {
    if ($libro["autor"] === "Ursula K. Le Guin") {
        echo $libro["titulo"] . "<br>";
    }
}
