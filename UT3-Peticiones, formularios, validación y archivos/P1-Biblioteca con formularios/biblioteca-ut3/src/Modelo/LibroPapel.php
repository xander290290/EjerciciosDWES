<?php

declare(strict_types=1);

namespace Xander\Biblioteca\Modelo;

final class LibroPapel extends Libro
{
    public function getTipo(): string
    {
        return 'papel';
    }

    public function costeReposicionCentimos(): int
    {
        return $this->getPaginas() * 5 * $this->getUnidades();
    }
}
