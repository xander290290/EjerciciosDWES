<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use XanderAyala\Biblioteca\Modelo\LibroDigital;
use XanderAyala\Biblioteca\Modelo\LibroPapel;
use XanderAyala\Biblioteca\Servicio\BibliotecaService;

$libros = require dirname(__DIR__) . '/datos/libros.php';
$servicio = new BibliotecaService($libros);
$camposTexto = [
    'tipo',
    'titulo',
    'autor',
    'paginas',
    'genero',
    'unidades',
    'fechaAlta',
    'observaciones',
    'correo',
];
$valores = array_fill_keys($camposTexto, '');
$valores['destacado'] = false;
$errores = [];
$ficha = null;
$filas = $servicio->filas($servicio->todos());
$resumen = $servicio->resumen($servicio->todos());

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    foreach ($camposTexto as $campo) {
        $valor = $_POST[$campo] ?? '';
        if (!is_string($valor)) {
            $errores[$campo] = 'El valor debe ser texto.';
            $valor = '';
        }

        $valores[$campo] = trim($valor);
    }

    $validarTexto = static function (
        string $campo,
        string $etiqueta,
        int $longitudMaxima
    ) use (&$errores, $valores): void {
        if (isset($errores[$campo])) {
            return;
        }
        if ($valores[$campo] === '') {
            $errores[$campo] = $etiqueta . ' es obligatorio.';
            return;
        }
        if (mb_strlen($valores[$campo], 'UTF-8') > $longitudMaxima) {
            $errores[$campo] = $etiqueta . ' no puede superar ' . $longitudMaxima . ' caracteres.';
        }
    };

    $validarTexto('titulo', 'El título', 120);
    $validarTexto('autor', 'El autor', 100);

    $enteros = [];
    foreach (['paginas' => [1, 3000], 'unidades' => [1, 50]] as $campo => [$minimo, $maximo]) {
        if (isset($errores[$campo])) {
            continue;
        }
        $entero = filter_var($valores[$campo], FILTER_VALIDATE_INT);
        if ($entero === false || $entero < $minimo || $entero > $maximo) {
            $errores[$campo] = 'Introduce un entero entre ' . $minimo . ' y ' . $maximo . '.';
            continue;
        }
        $enteros[$campo] = $entero;
    }

    if (!isset($errores['tipo']) && !in_array($valores['tipo'], ['papel', 'digital'], true)) {
        $errores['tipo'] = 'Selecciona un tipo válido.';
    }
    if (!isset($errores['genero'])
        && !in_array($valores['genero'], ['ciencia', 'fantasia', 'terror'], true)
    ) {
        $errores['genero'] = 'Selecciona un género válido.';
    }

    if (!isset($errores['observaciones'])
        && mb_strlen($valores['observaciones'], 'UTF-8') > 300
    ) {
        $errores['observaciones'] = 'Las observaciones no pueden superar 300 caracteres.';
    }

    if (!isset($errores['correo'])
        && ($valores['correo'] === '' || filter_var($valores['correo'], FILTER_VALIDATE_EMAIL) === false)
    ) {
        $errores['correo'] = 'Introduce un correo electrónico válido.';
    }

    $fechaAlta = null;
    if (!isset($errores['fechaAlta']) && $valores['fechaAlta'] !== '') {
        try {
            $fechaAlta = \DateTimeImmutable::createFromFormat('!Y-m-d', $valores['fechaAlta']);
        } catch (ValueError) {
            $fechaAlta = false;
        }

        if ($fechaAlta === false || $fechaAlta->format('Y-m-d') !== $valores['fechaAlta']) {
            $fechaAlta = null;
            $errores['fechaAlta'] = 'Introduce una fecha válida con formato YYYY-MM-DD.';
        }
    }

    if (array_key_exists('destacado', $_POST)) {
        if (is_string($_POST['destacado']) && $_POST['destacado'] === '1') {
            $valores['destacado'] = true;
        } else {
            $errores['destacado'] = 'El valor de destacado no es válido.';
        }
    }

    if ($errores === []) {
        try {
            $claseLibro = $valores['tipo'] === 'papel' ? LibroPapel::class : LibroDigital::class;
            $libro = new $claseLibro(
                $valores['titulo'],
                $valores['autor'],
                $enteros['paginas'],
                $valores['genero'],
                $enteros['unidades'],
                $fechaAlta,
                $valores['destacado'],
                $valores['observaciones']
            );
        } catch (\InvalidArgumentException $exception) {
            $errores['general'] = $exception->getMessage();
            $libro = null;
        }

        if ($libro !== null) {
            $servicio->agregar($libro);
            $ficha = $servicio->filas([$libro])[0];
            $filas = $servicio->filas($servicio->todos());
            $resumen = $servicio->resumen($servicio->todos());
        }
    }
}

require dirname(__DIR__) . '/vistas/alta.php';
