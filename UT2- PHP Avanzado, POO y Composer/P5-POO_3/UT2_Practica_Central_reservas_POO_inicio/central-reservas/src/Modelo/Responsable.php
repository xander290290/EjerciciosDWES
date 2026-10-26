<?php

declare(strict_types=1);

// TODO M4. Implementa Responsable final, sus propiedades readonly y el trait.
final class Responsable
{
    use GeneraEtiqueta;

    public function __construct(
        public readonly int $id,
        public readonly string $nombre
    ) {
        if ($id < 0 || trim($nombre) === '') {
            throw new InvalidArgumentException('Argumentos inválidos');
        }
    }

    public function id()
    {
        return $this->id;
    }
    public function nombre()
    {
        return $this->nombre;
    }
}
