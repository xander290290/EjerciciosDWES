<?php

namespace App;

use DateTimeImmutable;

class LibroFormService
{
    public function __construct(private Validator $validator)
    {
    }

    public function procesar(array $entrada): array
    {
        $valores = [
            'titulo' => trim((string) ($entrada['titulo'] ?? '')),
            'autor' => trim((string) ($entrada['autor'] ?? '')),
            'paginas' => trim((string) ($entrada['paginas'] ?? '')),
            'genero' => trim((string) ($entrada['genero'] ?? '')),
            'fechaAlta' => trim((string) ($entrada['fechaAlta'] ?? '')),
        ];

        $errores = [];

        if (($e = $this->validator->requerido($valores['titulo'], 'Título obligatorio')) !== null) {
            $errores['titulo'] = $e;
        }
        if (($e = $this->validator->requerido($valores['autor'], 'Autor obligatorio')) !== null) {
            $errores['autor'] = $e;
        }

        $paginasError = $this->validator->validarPaginas($valores['paginas']);
        if ($paginasError !== null) {
            $errores['paginas'] = $paginasError;
        }

        if (!in_array($valores['genero'], ['ciencia', 'fantasia', 'terror'], true)) {
            $errores['genero'] = 'Género no válido';
        }

        $fechaValida = null;
        if ($valores['fechaAlta'] !== '') {
            $fecha = DateTimeImmutable::createFromFormat('!Y-m-d', $valores['fechaAlta']);
            if ($fecha === false || $fecha->format('Y-m-d') !== $valores['fechaAlta']) {
                $errores['fechaAlta'] = 'Fecha inválida';
            } else {
                $fechaValida = $fecha;
            }
        }

        if ($errores !== []) {
            return ['valores' => $valores, 'errores' => $errores, 'datos' => null];
        }

        return [
            'valores' => $valores,
            'errores' => [],
            'datos' => [
                'titulo' => $valores['titulo'],
                'autor' => $valores['autor'],
                'genero' => $valores['genero'],
                'paginas' => (int) $valores['paginas'],
                'fechaAlta' => $fechaValida,
            ],
        ];
    }
}
