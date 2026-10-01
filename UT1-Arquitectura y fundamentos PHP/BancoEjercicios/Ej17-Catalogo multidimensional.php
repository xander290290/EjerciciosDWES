<?php

$catalogo = [
    [
        "titulo" => "Dune",
        "autor" => "Frank Herbert"
    ],
    [
        "titulo" => "1984",
        "autor" => "George Orwell"
    ],
    [
        "titulo" => "El nombre del viento",
        "autor" => "Patrick Rothfuss"
    ],
    [
        "titulo" => "Terramar",
        "autor" => "Ursula K. Le Guin"
    ]
];

foreach ($catalogo as $libro) {
    echo $libro["titulo"] . " - " . $libro["autor"] . PHP_EOL;
}

?>