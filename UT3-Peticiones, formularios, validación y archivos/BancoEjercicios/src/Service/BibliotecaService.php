<?php

namespace App\Service;

use App\Repository\LibroRepository;
use OutOfBoundsException;

class BibliotecaService
{
    public function __construct(private LibroRepository $repo)
    {
    }

    public function prestar(int $id): void
    {
        $libro = $this->repo->buscarPorId($id);
        if ($libro === null) {
            throw new OutOfBoundsException('Libro no encontrado');
        }
        $libro->prestar();
    }
}
