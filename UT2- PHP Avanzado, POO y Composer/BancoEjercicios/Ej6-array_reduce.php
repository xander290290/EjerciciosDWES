<?php

$catalogo = [456,234,456];

$total = array_reduce(
    $catalogo,
    fn (int $valorAcumulativo, int $p): int => $valorAcumulativo + $p,
    0
);

echo $total;