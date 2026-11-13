<?php

// Ejercicio 34: Probar la salida completa del servicio
require_once __DIR__ . '/../src/Validator.php';
require_once __DIR__ . '/../src/LibroFormService.php';

use App\LibroFormService;
use App\Validator;
use PHPUnit\Framework\TestCase;

final class FullServiceTest extends TestCase
{
    public function testServicioValido(): void
    {
        $service = new LibroFormService(new Validator());
        $resultado = $service->procesar([
            'titulo' => ' Dune ',
            'autor' => 'Frank Herbert',
            'paginas' => '412',
            'genero' => 'ciencia',
            'fechaAlta' => '',
        ]);

        $this->assertSame('412', $resultado['valores']['paginas']);
        $this->assertSame(412, $resultado['datos']['paginas']);
        $this->assertSame('Dune', $resultado['datos']['titulo']);
        $this->assertSame([], $resultado['errores']);
        $this->assertNull($resultado['datos']['fechaAlta']);
    }
}
