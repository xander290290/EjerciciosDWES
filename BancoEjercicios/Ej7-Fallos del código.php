<?php

$titulo = "Dune"; //Faltaba ;
$paginas = 412; //Estaba en string y hace falta en int

const max_prestamos = 3;

$disponible = true; //Faltaba ;

echo "Libro: " . $titulo; //Se concatena con . no con +

$puede = $paginas > 400 && $disponible === true; //Para comparar se usa ===