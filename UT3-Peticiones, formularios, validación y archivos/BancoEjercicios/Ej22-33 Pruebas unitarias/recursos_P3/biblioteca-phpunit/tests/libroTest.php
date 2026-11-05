<?php
use App\Model\Libro;
use PHPunit\Framework\TestCase;
use App\Model\LibroNoDisponibleException;

final class LibroTest extends TestCase {
    public function testConservaTitulo(): void {
        $libro = new Libro('Dune', 'Frank Herberlt', 412);
        $this->assertSame('Dune', $libro->titulo());
    }
    public function testCompruebaDisponible() {
        $libro = new Libro('Dune','Frank',412);
        $libro->prestar();
        $this->assertSame(412, $libro->paginas());
        $this->assertEquals("412", $libro->paginas());
        $this->assertFalse($libro->estaDisponible());
        $this->assertSame("Dune", $libro->titulo());
    }
    public function testExceptionNoDisponible() {
        $libro = new Libro('Dune', 'Frank Herbert', 412);
        $libro->prestar();
        $this->expectException(LibroNoDisponibleException::class);
        $libro->prestar();
    }
    public function testExceptionInvalidArgumentTitulo() {
        $this->expectException(InvalidArgumentException::class);
        $libro = new Libro('','Pepe',200);
    }
    public function testExceptionInvalidArgumentAutor() {
        $this->expectException(InvalidArgumentException::class);
        $libro = new Libro('Solaris','',200);
    }
}