<?php

// Ejercicio 35: Mantener independientes las pruebas
require_once __DIR__ . '/../src/Model/LibroNoDisponibleException.php';
require_once __DIR__ . '/../src/Model/Libro.php';

use App\Model\Libro;
use PHPUnit\Framework\TestCase;

final class LibroIndependienteTest extends TestCase
{
    private Libro $libro;

    protected function setUp(): void
    {
        $this->libro = new Libro('Dune', 'Frank Herbert', 412);
    }

    public function testDisponibleAlInicio(): void
    {
        $this->assertTrue($this->libro->disponible());
    }

    public function testPrestar(): void
    {
        $this->assertTrue($this->libro->prestar());
        $this->assertFalse($this->libro->disponible());
    }
}
