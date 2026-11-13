<?php

// Ejercicio 38: Mock de repositorio
require_once __DIR__ . '/../src/Model/LibroNoDisponibleException.php';
require_once __DIR__ . '/../src/Model/Libro.php';
require_once __DIR__ . '/../src/Repository/LibroRepository.php';
require_once __DIR__ . '/../src/Service/BibliotecaService.php';

use App\Model\Libro;
use App\Repository\LibroRepository;
use App\Service\BibliotecaService;
use PHPUnit\Framework\TestCase;

final class MockRepositoryTest extends TestCase
{
    public function testInteraccionConRepositorio(): void
    {
        $libro = new Libro('Dune', 'Frank Herbert', 412);
        $repo = $this->createMock(LibroRepository::class);
        $repo->expects($this->once())
            ->method('buscarPorId')
            ->with(1)
            ->willReturn($libro);

        $service = new BibliotecaService($repo);
        $service->prestar(1);

        $this->assertFalse($libro->disponible());
    }
}
