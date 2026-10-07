<?php

$paginas = [412, 328, 1504];

$mas1000 = array_any(
    $paginas,
    fn (int $l): bool => $l >= 1000
);

$mayor0= array_all(
    $paginas,
    fn (int $l): bool => $l > 0
);

echo 'Tiene mas de 1000?: ' . ($mas1000? 'true' : 'false') . '<br>';
echo 'Todos son mayores a 0?: ' . ($mayor0 ? 'true' : 'false');