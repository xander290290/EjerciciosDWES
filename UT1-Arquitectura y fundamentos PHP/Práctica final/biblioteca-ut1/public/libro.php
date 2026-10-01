<?php

declare(strict_types=1);

REQUIRE_ONCE __DIR__ . '/../src/funciones.php';
REQUIRE_ONCE __DIR__ . '/../src/datos.php';

$id = $_GET['id']?? null;

$escId = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');

if($id !== null){
    echo "El libro es: " . busquedaPorId($libros, $id);
} else {
    echo "El libro no se encuentra en la base de datos";
}

echo "xd" . ordenarPaginas($catalogo);
