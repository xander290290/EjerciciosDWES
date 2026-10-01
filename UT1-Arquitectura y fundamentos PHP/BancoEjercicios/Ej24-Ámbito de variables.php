<?php

$contador = 0;

function incrementar($contador) //Hay que definir la variable como argumento de la funcion
{
    $contador++;
}

incrementar($contador); //La variable se pasa como argumento para que este en el mismo ámbito

echo $contador;