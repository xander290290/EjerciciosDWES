<?php

declare(strict_types=1);

namespace XanderAyala\Biblioteca\Servicio;

use InvalidArgumentException;
use XanderAyala\Biblioteca\Modelo\Libro;

final class BibliotecaService
{
    private array $libros;

    public function __construct(array $libros)
    {
        foreach ($libros as $libro) {
            if (!$libro instanceof Libro) {
                throw new InvalidArgumentException('La colección solo puede contener libros.');
            }
        }

        $this->libros = $libros;
    }

    public function todos(): array
    {
        return $this->libros;
    }

    public function agregar(Libro $libro): void
    {
        $this->libros[] = $libro;
    }

    public function filtrar(
        string $q,
        string $genero,
        string $tipo,
        bool $soloDestacados
    ): array {
        $q = trim($q);

        $filtrados = array_filter(
            $this->libros,
            static function (Libro $libro) use ($q, $genero, $tipo, $soloDestacados): bool {
                if ($q !== ''
                    && mb_stripos($libro->getTitulo(), $q, 0, 'UTF-8') === false
                    && mb_stripos($libro->getAutor(), $q, 0, 'UTF-8') === false
                ) {
                    return false;
                }

                if ($genero !== '' && $libro->getGenero() !== $genero) {
                    return false;
                }
                if ($tipo !== '' && $libro->getTipo() !== $tipo) {
                    return false;
                }
                if ($soloDestacados && !$libro->isDestacado()) {
                    return false;
                }

                return true;
            }
        );

        return array_values($filtrados);
    }

    public function filas(array $libros): array
    {
        return array_map(
            static function (Libro $libro): array {
                return [
                    'titulo' => $libro->getTitulo(),
                    'autor' => $libro->getAutor(),
                    'paginas' => $libro->getPaginas(),
                    'genero' => $libro->getGenero(),
                    'tipo' => $libro->getTipo(),
                    'unidades' => $libro->getUnidades(),
                    'fechaAlta' => $libro->getFechaAlta()?->format('Y-m-d') ?? 'Sin fecha',
                    'destacado' => $libro->isDestacado(),
                    'observaciones' => $libro->getObservaciones(),
                    'costeCentimos' => $libro->costeReposicionCentimos(),
                ];
            },
            $libros
        );
    }

    public function resumen(array $libros): array
    {
        return array_reduce(
            $libros,
            static function (array $resumen, Libro $libro): array {
                $resumen['titulos']++;
                $resumen['unidades'] += $libro->getUnidades();
                $resumen['paginas'] += $libro->getPaginas();
                $resumen['costeCentimos'] += $libro->costeReposicionCentimos();

                return $resumen;
            },
            [
                'titulos' => 0,
                'unidades' => 0,
                'paginas' => 0,
                'costeCentimos' => 0,
            ]
        );
    }
}
