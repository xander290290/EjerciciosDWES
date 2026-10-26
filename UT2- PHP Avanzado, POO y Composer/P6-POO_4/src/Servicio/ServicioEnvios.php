<?php
declare(strict_types=1);

namespace App\Servicio;

use App\Contrato\RepositorioEnvios;
use App\Excepcion\EnvioException;
use App\Modelo\Envio;
use App\Modelo\EstadoEnvio;
use InvalidArgumentException;

final class ServicioEnvios
{
    public function __construct(private readonly RepositorioEnvios $repositorio)
    {
    }

    public function enviar(int $id): void
    {
        $this->obtener($id)->enviar();
    }

    public function entregar(int $id): void
    {
        $this->obtener($id)->entregar();
    }

    public function cancelar(int $id): void
    {
        $this->obtener($id)->cancelar();
    }

    public function consultar(
        string $texto = '',
        ?string $modalidad = null,
        ?EstadoEnvio $estado = null,
        string $orden = 'precio'
    ): array {
        if ($modalidad !== null && !in_array($modalidad, ['normal', 'urgente'], true)) {
            throw new InvalidArgumentException('La modalidad debe ser normal o urgente.');
        }
        if (!in_array($orden, ['precio', 'peso'], true)) {
            throw new InvalidArgumentException('El orden debe ser precio o peso.');
        }

        $busqueda = self::normalizar($texto);
        $envios = array_filter(
            $this->repositorio->todos(),
            static function (Envio $envio) use ($busqueda, $modalidad, $estado): bool {
                return ($busqueda === '' || str_contains(self::normalizar($envio->cliente()), $busqueda))
                    && ($modalidad === null || $envio->modalidad() === $modalidad)
                    && ($estado === null || $envio->estado() === $estado);
            }
        );

        usort($envios, static function (Envio $a, Envio $b) use ($orden): int {
            $comparacion = $orden === 'precio'
                ? $a->tarifa() <=> $b->tarifa()
                : $a->peso() <=> $b->peso();

            return $comparacion !== 0 ? $comparacion : $a->id() <=> $b->id();
        });

        return array_values($envios);
    }

    public function etiquetas(array $envios): array
    {
        return array_map(
            static fn (Envio $envio): string => sprintf(
                '%d | %s | %s | %s | %d céntimos',
                $envio->id(),
                $envio->cliente(),
                $envio->modalidad(),
                $envio->estado()->value,
                $envio->tarifa()
            ),
            $envios
        );
    }

    public function resumir(array $envios): array
    {
        $resumen = [
            'cantidad' => 0,
            'peso' => 0,
            'importeTotal' => 0,
            'importeActivo' => 0,
            'pendiente' => 0,
            'enviado' => 0,
            'entregado' => 0,
            'cancelado' => 0,
        ];

        foreach ($envios as $envio) {
            $estado = $envio->estado();
            $tarifa = $envio->tarifa();

            $resumen['cantidad']++;
            $resumen['peso'] += $envio->peso();
            $resumen['importeTotal'] += $tarifa;
            if ($estado !== EstadoEnvio::Cancelado) {
                $resumen['importeActivo'] += $tarifa;
            }
            $resumen[$estado->value]++;
        }

        return $resumen;
    }

    private function obtener(int $id): Envio
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('El id debe ser positivo.');
        }

        return $this->repositorio->buscar($id)
            ?? throw new EnvioException(sprintf('No existe un envío con id %d.', $id));
    }

    private static function normalizar(string $texto): string
    {
        $normalizado = preg_replace('/\s+/u', ' ', trim($texto));
        if ($normalizado === null) {
            throw new InvalidArgumentException('El texto debe estar codificado en UTF-8 válido.');
        }

        return mb_strtolower($normalizado, 'UTF-8');
    }
}
