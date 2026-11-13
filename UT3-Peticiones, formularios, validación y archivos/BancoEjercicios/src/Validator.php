<?php

namespace App;

use DateTimeImmutable;

class Validator
{
    public function requerido(string $valor, string $mensaje): ?string
    {
        return trim($valor) === '' ? $mensaje : null;
    }

    public function validarPaginas(mixed $entrada): ?string
    {
        if (!is_string($entrada)) {
            return 'Tipo de dato no válido';
        }

        $valor = trim($entrada);
        if ($valor === '') {
            return 'Páginas obligatorias';
        }
        if (filter_var($valor, FILTER_VALIDATE_INT) === false) {
            return 'Número de páginas no válido';
        }

        $paginas = (int) $valor;
        if ($paginas < 1 || $paginas > 3000) {
            return 'Debe estar entre 1 y 3000';
        }
        return null;
    }

    public function validarFechaOpcional(mixed $entrada): ?string
    {
        if ($entrada === null || (is_string($entrada) && trim($entrada) === '')) {
            return null;
        }
        if (!is_string($entrada)) {
            return 'Tipo de fecha no válido';
        }

        $texto = trim($entrada);
        $fecha = DateTimeImmutable::createFromFormat('!Y-m-d', $texto);
        if ($fecha === false || $fecha->format('Y-m-d') !== $texto) {
            return 'Fecha inválida';
        }
        return null;
    }
}
