<?php
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    http_response_code(405);
    exit('Método no permitido. Debería ser POST');
}

$titulo = $_POST['titulo'] ?? '';
if (!is_string($titulo)) {
    http_response_code(400);
    exit('Tl título debe de ser un string');
}
$tit = trim($titulo);
if ($tit === '') {
    http_response_code(400);
    exit('El titulo no puede estar vacío');
}

$autor = $_POST['titulo'] ?? '';
if (!is_string($autor)) {
    http_response_code(400);
    exit('El autor debe de ser un string');
}
$aut = trim($autor);
if ($aut === '') {
    http_response_code(400);
    exit('El autor no puede estar vacío');
}

$entadaPaginas = $_POST['paginas'] ?? '';
$paginas = is_string($entradaPaginas)? filter_var($entadaPaginas, FILTER_VALIDATE_INT) : false;
if ($paginas === false){
    http_response_code(400);
    exit('Valor no aceptado como número');
}
var_dump($entradaPaginas);
echo 'Titulo: ' . $tit . 'Autor: ' . $aut . 'Páginas: ' . $paginas;
