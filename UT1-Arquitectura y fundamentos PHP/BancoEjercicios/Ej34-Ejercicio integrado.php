<?php

declare(strict_types=1);

date_default_timezone_set("Europe/Madrid");

$catalogo = [
    [
        "titulo" => "Dune",
        "autor" => "Frank Herbert",
        "genero" => "Ciencia ficción",
        "paginas" => 412
    ],
    [
        "titulo" => "El nombre del viento",
        "autor" => "Patrick Rothfuss",
        "genero" => "Fantasía",
        "paginas" => 872
    ],
    [
        "titulo" => "1984",
        "autor" => "George Orwell",
        "genero" => "Ciencia ficción",
        "paginas" => 328
    ],
    [
        "titulo" => "Terramar",
        "autor" => "Ursula K. Le Guin",
        "genero" => "Fantasía",
        "paginas" => 320
    ],
    [
        "titulo" => "Drácula",
        "autor" => "Bram Stoker",
        "genero" => "Terror",
        "paginas" => 488
    ],
    [
        "titulo" => "Frankenstein",
        "autor" => "Mary Shelley",
        "genero" => "Terror",
        "paginas" => 280
    ]
];

function filtrarPorGenero(array $catalogo, string $genero): array
{
    if ($genero === "todos") {
        return $catalogo;
    }

    $resultado = [];

    foreach ($catalogo as $libro) {
        if ($libro["genero"] === $genero) {
            $resultado[] = $libro;
        }
    }

    return $resultado;
}

function ordenarPorTitulo(array &$libros): void
{
    $cantidad = count($libros);

    // Ordenación manual mediante intercambio
    for ($i = 0; $i < $cantidad - 1; $i++) {

        for ($j = $i + 1; $j < $cantidad; $j++) {

            if (strcmp($libros[$i]["titulo"], $libros[$j]["titulo"]) > 0) {
                $temporal = $libros[$i];
                $libros[$i] = $libros[$j];
                $libros[$j] = $temporal;
            }
        }
    }
}

$genero = $_GET["genero"] ?? "todos";

$librosFiltrados = filtrarPorGenero($catalogo, $genero);

ordenarPorTitulo($librosFiltrados);

$totalResultados = count($librosFiltrados);

$fechaRevision = new DateTimeImmutable();
$fechaRevision = $fechaRevision->modify("+30 days");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de libros</title>
</head>

<body>

<h1>Catálogo de libros</h1>

<p>
    Género seleccionado:
    <strong><?= htmlspecialchars($genero, ENT_QUOTES, 'UTF-8') ?></strong>
</p>

<p>
    Resultados encontrados: <?= $totalResultados ?>
</p>

<ul>

    <?php foreach ($librosFiltrados as $libro): ?>

        <li>
            <strong>
                <?= htmlspecialchars($libro["titulo"], ENT_QUOTES, 'UTF-8') ?>
            </strong>
            -
            <?= htmlspecialchars($libro["autor"], ENT_QUOTES, 'UTF-8') ?>
            -
            <?= htmlspecialchars($libro["genero"], ENT_QUOTES, 'UTF-8') ?>
            -
            <?= $libro["paginas"] ?> páginas
        </li>

    <?php endforeach; ?>

</ul>

<p>
    Próxima revisión del catálogo:
    <?= $fechaRevision->format("d/m/Y") ?>
</p>

</body>
</html>