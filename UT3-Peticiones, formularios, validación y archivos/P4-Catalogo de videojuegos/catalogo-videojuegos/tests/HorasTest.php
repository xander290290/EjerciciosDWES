<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function App\Soporte\validarVideojuego;

final class HorasTest extends TestCase
{
    // COMPLETAR 9. Proveedor y prueba de los cinco valores de horas.

    public static function casosHoras(): array
    {
        return [
            'mínimo permitido' => ['1', true],
            'máximo permitido' => ['300', true],
            'por debajo del mínimo' => ['0', false],
            'por encima del máximo' => ['301', false],
            'no es un entero' => ['12abc', false],
        ];
    }

    #[DataProvider('casosHoras')]
    public function testValidaHoras(string $horas, bool $esValido): void
    {
        $datos = $this->datosValidos();
        $datos['horas'] = $horas;

        $resultado = validarVideojuego($datos);

        self::assertSame(!$esValido, isset($resultado['errores']['horas']));

        if ($esValido) {
            self::assertSame((int) $horas, $resultado['datos']['horas']);
            self::assertIsInt($resultado['datos']['horas']);
        } else {
            self::assertNull($resultado['datos']);
        }
    }

    // Proporcionado. Datos válidos sobre los que varías solo horas.
    private function datosValidos(): array
    {
        return [
            'titulo' => 'Islas de cristal',
            'estudio' => 'Nébula Studio',
            'horas' => '35',
            'genero' => 'aventura',
            'fechaLanzamiento' => '',
        ];
    }
}
