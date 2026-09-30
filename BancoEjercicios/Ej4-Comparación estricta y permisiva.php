<?php

$a = (5 == "5"); //true == es permisivo con los tipos
$b = (5 === "5"); //false === no es permisivo con los tipos
$c = (10 > 5 && 3 < 2); //false 10 es mayor que 5 pero 3 no es menor que 2
$d = !$b || $c; // true $c da falso, pero en cambio el contrarior de $b es true, asi que dara true