<?php

declare(strict_types=1);

function esLargo(int $paginas): bool
{
    return $paginas > 500;
}

echo esLargo(600) ? "Sí" : "No";

//Si se le pasa "600" la funcion da error, ya que el strict type obliga a pasar los argumentos con el tipo que se declara