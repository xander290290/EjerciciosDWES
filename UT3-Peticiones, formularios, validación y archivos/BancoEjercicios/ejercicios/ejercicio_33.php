<?php

// Ejercicio 33: Probar páginas con casos parametrizados
require_once __DIR__ . '/../src/Validator.php';
require_once __DIR__ . '/../src/LibroFormService.php';

use App\LibroFormService;
use App\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class PaginasTest extends TestCase
{
    public static function casos(): array
    {
        return [
            'uno' => ['1', true],
            'max' => ['3000', true],
            'cero' => ['0', false],
            'muyGrande' => ['3001', false],
            'cadena' => ['12abc', false],
            'decimal' => ['12.5', false],
            'array' => [['412'], false],
        ];
    }

    #[DataProvider('casos')]
    public function testPaginaValida(mixed $entrada, bool $esperado): void
    {
        $service = new LibroFormService(new Validator());
        $resultado = $service->procesar([
            'titulo' => 'Dune',
            'autor' => 'Frank Herbert',
            'paginas' => $entrada,
            'genero' => 'ciencia',
            'fechaAlta' => '',
        ]);

        if ($esperado) {
            $this->assertArrayHasKey('paginas', $resultado['datos']);
        } else {
            $this->assertNull($resultado['datos']);
        }
    }
}
