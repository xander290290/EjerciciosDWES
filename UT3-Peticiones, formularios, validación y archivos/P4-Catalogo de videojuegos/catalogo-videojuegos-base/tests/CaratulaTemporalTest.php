<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use function App\Soporte\inspeccionarCaratula;

final class CaratulaTemporalTest extends TestCase
{
    private ?string $temporal = null;

    // COMPLETAR 10. setUp, prueba de rechazo y tearDown.

    protected function setUp(): void
    {
        parent::setUp();

        $temporal = tempnam(sys_get_temp_dir(), 'ut3_');

        if ($temporal === false) {
            throw new RuntimeException('No se ha podido crear el archivo temporal de prueba.');
        }

        $this->temporal = $temporal;

        if (file_put_contents($this->temporal, 'contenido que no es una imagen') === false) {
            throw new RuntimeException('No se ha podido escribir el archivo temporal de prueba.');
        }
    }

    public function testRechazaUnArchivoDeTextoComoCaratula(): void
    {
        $resultado = inspeccionarCaratula($this->entradaArchivo());

        self::assertNull($resultado['archivo']);
        self::assertNotNull($resultado['error']);
    }

    protected function tearDown(): void
    {
        if ($this->temporal !== null && is_file($this->temporal)) {
            unlink($this->temporal);
        }

        if ($this->temporal !== null) {
            self::assertFileDoesNotExist($this->temporal);
        }

        parent::tearDown();
    }

    // Proporcionado. Representa el temporal como entrada de inspeccionarCaratula.
    private function entradaArchivo(): array
    {
        if ($this->temporal === null || !is_file($this->temporal)) {
            throw new RuntimeException('El temporal de prueba no está preparado.');
        }

        return [
            'caratula' => [
                'error' => UPLOAD_ERR_OK,
                'size' => filesize($this->temporal),
                'tmp_name' => $this->temporal,
            ],
        ];
    }
}
