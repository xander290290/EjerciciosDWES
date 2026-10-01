<?php

$catalogo = [435,234,476];

$etiqueta = array_map(
    fn (int $p): string => "Dune - $p pag",
    $catalogo
);

print_r($etiqueta);