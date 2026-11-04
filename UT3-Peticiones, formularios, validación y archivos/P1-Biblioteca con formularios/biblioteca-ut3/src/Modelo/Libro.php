<?php

declare(strict_types=1);

namespace Xander\Biblioteca\Modelo;

use DateTimeImmutable;
use InvalidArgumentException;

abstract class Libro
{
    private string $titulo;
    private string $autor;
    private int $paginas;
    private string $genero;
    private int $unidades;
    private ?DateTimeImmutable $fechaAlta;
    private bool $destacado;
    private string $observaciones;

    public function __construct(
        string $titulo,
        string $autor,
        int $paginas,
        string $genero,
        int $unidades,
        ?DateTimeImmutable $fechaAlta,
        bool $destacado,
        string $observaciones
    ) {
        $titulo = trim($titulo);
        $autor = trim($autor);
        $observaciones = trim($observaciones);

        if ($titulo === '' || mb_strlen($titulo, 'UTF-8') > 120) {
            throw new InvalidArgumentException('El título es obligatorio y no puede superar 120 caracteres.');
        }
        if ($autor === '' || mb_strlen($autor, 'UTF-8') > 100) {
            throw new InvalidArgumentException('El autor es obligatorio y no puede superar 100 caracteres.');
        }
        if ($paginas < 1 || $paginas > 3000) {
            throw new InvalidArgumentException('Las páginas deben estar entre 1 y 3000.');
        }
        if (!in_array($genero, ['ciencia', 'fantasia', 'terror'], true)) {
            throw new InvalidArgumentException('El género no es válido.');
        }
        if ($unidades < 1 || $unidades > 50) {
            throw new InvalidArgumentException('Las unidades deben estar entre 1 y 50.');
        }
        if (mb_strlen($observaciones, 'UTF-8') > 300) {
            throw new InvalidArgumentException('Las observaciones no pueden superar 300 caracteres.');
        }

        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->paginas = $paginas;
        $this->genero = $genero;
        $this->unidades = $unidades;
        $this->fechaAlta = $fechaAlta;
        $this->destacado = $destacado;
        $this->observaciones = $observaciones;
    }

    abstract public function getTipo(): string;

    abstract public function costeReposicionCentimos(): int;

    public function getTitulo(): string
    {
        return $this->titulo;
    }

    public function getAutor(): string
    {
        return $this->autor;
    }

    public function getPaginas(): int
    {
        return $this->paginas;
    }

    public function getGenero(): string
    {
        return $this->genero;
    }

    public function getUnidades(): int
    {
        return $this->unidades;
    }

    public function getFechaAlta(): ?DateTimeImmutable
    {
        return $this->fechaAlta;
    }

    public function isDestacado(): bool
    {
        return $this->destacado;
    }

    public function getObservaciones(): string
    {
        return $this->observaciones;
    }
}
