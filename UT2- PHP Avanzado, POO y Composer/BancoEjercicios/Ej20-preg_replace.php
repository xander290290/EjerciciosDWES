<?php

$texto = 'texto   con espacios y   saltos de línea';

$normalizado = preg_replace('/\s+/',' ', $texto);

echo $normalizado;