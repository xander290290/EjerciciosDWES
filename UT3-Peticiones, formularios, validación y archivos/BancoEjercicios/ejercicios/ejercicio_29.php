<?php

// Ejercicio 29: PHPUnit y primera prueba
require_once __DIR__ . '/../src/Model/LibroNoDisponibleException.php';
require_once __DIR__ . '/../src/Model/Libro.php';

use App\Model\Libro;
use PHPUnit\Framework\TestCase;

final class LibroTest extends TestCase
{
    public function testConservaTitulo(): void
    {
        $libro = new Libro('Dune', 'Frank Herbert', 412);
        self::assertSame('Dune', $libro->titulo());
    }
}
