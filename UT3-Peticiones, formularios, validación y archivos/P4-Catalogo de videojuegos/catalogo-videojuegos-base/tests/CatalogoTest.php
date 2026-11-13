<?php

declare(strict_types=1);

use App\Modelo\Videojuego;
use PHPUnit\Framework\TestCase;

final class CatalogoTest extends TestCase
{
    // COMPLETAR 8. Creación válida y estado del objeto.

    public function testCreaVideojuegoValidoYRecortaLosTextos(): void
    {
        $videojuego = new Videojuego('  Islas de cristal  ', '  Nébula Studio  ', 35, 'aventura');

        self::assertSame('Islas de cristal', $videojuego->titulo());
        self::assertSame('Nébula Studio', $videojuego->estudio());
        self::assertSame(35, $videojuego->horas());
        self::assertNull($videojuego->fechaLanzamiento());
    }

}
