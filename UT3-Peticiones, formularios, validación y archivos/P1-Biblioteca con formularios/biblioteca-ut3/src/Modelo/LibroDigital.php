<?php

declare(strict_types=1);

namespace XanderAyala\Biblioteca\Modelo;

final class LibroDigital extends Libro
{
    public function getTipo(): string
    {
        return 'digital';
    }

    public function costeReposicionCentimos(): int
    {
        return 400 * $this->getUnidades();
    }
}
