<?php

declare(strict_types=1);

use App\Modelo\Pelicula;
use PHPUnit\Framework\TestCase;

final class CatalogoTest extends TestCase
{
    // COMPLETAR 8. Creación válida y estado del objeto.
    private function creacionValida () {
        $peli = new Pelicula(' Dune ', ' Denis Villeneuve ', 155, 'ciencia');

        self::assert($peli->titulo(), 'Dune');
        self::asert($peli->autor(), 'Denis Villeneuve');
        self::same($peli->duracion(), 155);
        self::same($peli->fechaEstreno, null);
    }
}
