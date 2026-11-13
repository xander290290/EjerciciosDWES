<?php

declare(strict_types=1);

use App\Modelo\Pelicula;
use PHPUnit\Framework\TestCase;

final class CatalogoTest extends TestCase
{
    // COMPLETAR 8. Creación válida y estado del objeto.
    public function testCreacionValida()
    {
        $peli = new Pelicula(' Dune ', ' Denis Villeneuve ', 155, 'ciencia');

        $this->assertSame('Dune', $peli->titulo());
        $this->assertSame('Denis Villeneuve', $peli->director());
        $this->assertSame(155, $peli->duracion());
        $this->assertNull($peli->fechaEstreno());
    }
}
