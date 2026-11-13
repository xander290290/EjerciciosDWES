<?php

// Ejercicio 32: DataProvider para regla requerida
require_once __DIR__ . '/../src/Validator.php';

use App\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class ValidatorTest extends TestCase
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
    public function testRequeridoConCadenasVacias(string $titulo): void
    {
        $validator = new Validator();
        $this->assertSame('Título obligatorio', $validator->requerido($titulo, 'Título obligatorio'));
    }

    public function testRequeridoConValorValido(): void
    {
        $validator = new Validator();
        $this->assertNull($validator->requerido('Dune', 'Título obligatorio'));
    }
}
