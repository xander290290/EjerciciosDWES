<?php

namespace App\Model;

use DateTimeImmutable;
use InvalidArgumentException;

class Libro
{
    public const GENEROS = ['ciencia', 'fantasia', 'terror'];

    private string $titulo;
    private string $autor;
    private int $paginas;
    private string $genero;
    private ?DateTimeImmutable $fechaAlta;
    private bool $disponible = true;
    private ?string $portada = null;

    public function __construct(string $titulo, string $autor, int $paginas, string $genero = 'ciencia', ?DateTimeImmutable $fechaAlta = null)
    {
        if (trim($titulo) === '') {
            throw new InvalidArgumentException('Título obligatorio');
        }
        if (trim($autor) === '') {
            throw new InvalidArgumentException('Autor obligatorio');
        }
        if ($paginas < 1 || $paginas > 3000) {
            throw new InvalidArgumentException('Páginas fuera de rango');
        }
        if (!in_array($genero, self::GENEROS, true)) {
            throw new InvalidArgumentException('Género no válido');
        }

        $this->titulo = trim($titulo);
        $this->autor = trim($autor);
        $this->paginas = $paginas;
        $this->genero = $genero;
        $this->fechaAlta = $fechaAlta;
    }

    public function titulo(): string
    {
        return $this->titulo;
    }

    public function autor(): string
    {
        return $this->autor;
    }

    public function paginas(): int
    {
        return $this->paginas;
    }

    public function genero(): string
    {
        return $this->genero;
    }

    public function fechaAlta(): ?DateTimeImmutable
    {
        return $this->fechaAlta;
    }

    public function disponible(): bool
    {
        return $this->disponible;
    }

    public function prestar(): bool
    {
        if (!$this->disponible) {
            throw new LibroNoDisponibleException('El libro ya no está disponible');
        }
        $this->disponible = false;
        return true;
    }

    public function devolver(): void
    {
        $this->disponible = true;
    }

    public function cambiarPortada(?string $nombre): void
    {
        $this->portada = $nombre;
    }

    public function portada(): ?string
    {
        return $this->portada;
    }

    public function actualizarDatos(string $titulo, string $autor, int $paginas, string $genero, ?DateTimeImmutable $fechaAlta): void
    {
        if (trim($titulo) === '') {
            throw new InvalidArgumentException('Título obligatorio');
        }
        if (trim($autor) === '') {
            throw new InvalidArgumentException('Autor obligatorio');
        }
        if ($paginas < 1 || $paginas > 3000) {
            throw new InvalidArgumentException('Páginas fuera de rango');
        }
        if (!in_array($genero, self::GENEROS, true)) {
            throw new InvalidArgumentException('Género no válido');
        }

        $this->titulo = trim($titulo);
        $this->autor = trim($autor);
        $this->paginas = $paginas;
        $this->genero = $genero;
        $this->fechaAlta = $fechaAlta;
    }
}
