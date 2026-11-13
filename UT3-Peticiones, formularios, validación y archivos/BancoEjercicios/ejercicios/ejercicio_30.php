<?php

// Ejercicio 30: Aserciones y lectura de fallos
require_once __DIR__ . '/../src/Model/LibroNoDisponibleException.php';
require_once __DIR__ . '/../src/Model/Libro.php';

use App\Model\Libro;
use PHPUnit\Framework\TestCase;

final class TestPrestarLibro extends TestCase
{
    public function testPrestarLibro(): void
    {
        $libro = new Libro('Dune', 'Frank Herbert', 412);
        $this->assertTrue($libro->disponible());
        $this->assertTrue($libro->prestar());
        $this->assertFalse($libro->disponible());
    }
}
