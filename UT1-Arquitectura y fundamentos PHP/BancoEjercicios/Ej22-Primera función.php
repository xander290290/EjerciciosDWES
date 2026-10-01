<?php

$paginas = 1829;

function esLargo($pag) {
    return $pag > 500;
}

echo (esLargo($paginas)) ? "true": "false";