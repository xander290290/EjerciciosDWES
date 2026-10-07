<?php

function sumarPaginas (int ...$pag): int 
{
    return array_sum($pag);
}

$paginas = [32,43,12];

echo sumarPaginas(...$paginas);