<?php

$paginas = [412, 328, 576, 215, 890, 350, 475, 620];


for ($i = 0; $i < count($paginas) - 1; $i++) {

    for ($j = $i + 1; $j < count($paginas); $j++) {

        if ($paginas[$i] > $paginas[$j]) {
            $temporal = $paginas[$i];
            $paginas[$i] = $paginas[$j];
            $paginas[$j] = $temporal;
        }
    }
}

$suma = 0;

foreach ($paginas as $numero) {
    $suma += $numero;
}

$minimo = $paginas[0];
$maximo = $paginas[count($paginas) - 1];
$media = $suma / count($paginas);

echo "Páginas ordenadas: " . implode(", ", $paginas) . PHP_EOL;
echo "Mínimo: " . $minimo . PHP_EOL;
echo "Máximo: " . $maximo . PHP_EOL;
echo "Media: " . $media . PHP_EOL;
