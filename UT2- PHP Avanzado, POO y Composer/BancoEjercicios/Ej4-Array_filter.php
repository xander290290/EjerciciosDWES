<?php

$catalogo = [456,234,456];

$ord = array_filter (
    $catalogo,
    fn (int $p): bool => $p < 300
);

print_r($ord);