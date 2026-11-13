<?php

// Ejercicio 26: Sustituir una portada y compensar un fallo
$anterior = 'a123';
$nueva = 'b456';
$actualizacionCorrecta = true;

if ($actualizacionCorrecta) {
    echo 'Se conserva la nueva portada y se elimina la antigua';
} else {
    echo 'Se restaura la anterior y se borra la nueva';
}
