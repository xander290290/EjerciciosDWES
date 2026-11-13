<?php

// Ejercicio 31: Excepciones del modelo
require_once __DIR__ . '/../src/Model/LibroNoDisponibleException.php';
require_once __DIR__ . '/../src/Model/Libro.php';

use App\Model\Libro;
use App\Model\LibroNoDisponibleException;
use PHPUnit\Framework\TestCase;

final class TestExcepcionesLibro extends TestCase
{
    public function testPrestarDosVecesLanzaExcepcion(): void
    {
        $libro = new Libro('Dune', 'Frank Herbert', 412);
        $libro->prestar();

        $this->expectException(LibroNoDisponibleException::class);
        $libro->prestar();
    }

    public function testTituloVacioLanzaExcepcion(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Libro('', 'Frank Herbert', 412);
    }
}
