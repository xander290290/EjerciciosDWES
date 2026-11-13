<?php

// Ejercicio 36: Probar la colaboración con el repositorio
require_once __DIR__ . '/../src/Model/LibroNoDisponibleException.php';
require_once __DIR__ . '/../src/Model/Libro.php';
require_once __DIR__ . '/../src/Repository/LibroRepository.php';
require_once __DIR__ . '/../src/Repository/ArrayLibroRepository.php';
require_once __DIR__ . '/../src/Service/BibliotecaService.php';

use App\Model\Libro;
use App\Repository\ArrayLibroRepository;
use App\Service\BibliotecaService;
use PHPUnit\Framework\TestCase;

final class BibliotecaServiceTest extends TestCase
{
    public function testPrestarLibroExistente(): void
    {
        $repo = new ArrayLibroRepository();
        $id = $repo->guardar(new Libro('Dune', 'Frank Herbert', 412));

        $service = new BibliotecaService($repo);
        $service->prestar($id);

        $this->assertFalse($repo->buscarPorId($id)->disponible());
    }
}
