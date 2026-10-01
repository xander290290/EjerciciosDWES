<?php

$texto = "PHP";
$i = 0;
while ($i < strlen($texto)) {
 if ($i === 1) {
 echo "-";
 }
 echo $texto[$i];
 $i++;
}
// El bucle se ejecuta 3 veces e imprime "P-HP"