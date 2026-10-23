<?php
declare(strict_types=1);

namespace App\Repositorio;

use App\Contrato\RepositorioEnvios;
use App\Excepcion\EnvioException;
use App\Modelo\Envio;
use InvalidArgumentException;

final class RepositorioEnviosMemoria implements RepositorioEnvios
{
    private array $envios = [];

    public function registrar(Envio $envio): void
    {
        if ($this->buscar($envio->id()) !== null) {
            throw new EnvioException(sprintf('Ya existe un envío con id %d.', $envio->id()));
        }

        $this->envios[] = $envio;
    }

    public function todos(): array
    {
        return $this->envios;
    }

    public function buscar(int $id): ?Envio
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('El id debe ser positivo.');
        }

        foreach ($this->envios as $envio) {
            if ($envio->id() === $id) {
                return $envio;
            }
        }

        return null;
    }
}
