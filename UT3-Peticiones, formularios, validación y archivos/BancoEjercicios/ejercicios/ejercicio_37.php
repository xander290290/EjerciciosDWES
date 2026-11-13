<?php

// Ejercicio 37: Stub para caso inexistente
require_once __DIR__ . '/../src/Model/LibroNoDisponibleException.php';
require_once __DIR__ . '/../src/Model/Libro.php';
require_once __DIR__ . '/../src/Repository/LibroRepository.php';
require_once __DIR__ . '/../src/Service/BibliotecaService.php';

use App\Repository\LibroRepository;
use App\Service\BibliotecaService;
use PHPUnit\Framework\TestCase;

final class StubRepositoryTest extends TestCase
{
    public function testPrestarLibroInexistente(): void
    {
        $repo = $this->createStub(LibroRepository::class);
        $repo->method('buscarPorId')->willReturn(null);

        $service = new BibliotecaService($repo);

        $this->expectException(OutOfBoundsException::class);
        $service->prestar(999);
    }
}
