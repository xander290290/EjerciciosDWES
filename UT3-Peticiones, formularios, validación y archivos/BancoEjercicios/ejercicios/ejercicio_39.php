<?php

// Ejercicio 39: Regresion y filtro de pruebas
require_once __DIR__ . '/../src/Validator.php';

use App\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class RegresionValidatorTest extends TestCase
{
    public static function titulosVacios(): array
    {
        return [
            'vacio' => [''],
            'espacios' => ['   '],
            'tabulacion' => ["	"],
        ];
    }

    #[DataProvider('titulosVacios')]
    public function testTituloRequerido(string $titulo): void
    {
        $validator = new Validator();
        $this->assertSame('Título obligatorio', $validator->requerido($titulo, 'Título obligatorio'));
    }
}
