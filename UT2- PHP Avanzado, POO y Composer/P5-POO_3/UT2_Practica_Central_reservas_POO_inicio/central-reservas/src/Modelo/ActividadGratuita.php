<?php
declare(strict_types=1);

// TODO M7. Implementa la especialización final gratuita.
final class ActividadGratuita extends Actividad{
    public function __construct (
        private readonly int $id,
        private readonly string $nombre,
        private readonly int $capacidad,
        private int $ocupadas,
        private readonly EstadoActividad $estado,
        private readonly ?Responsable $responsable
    ){
        parent::__construct($id, $nombre, $capacidad, $ocupadas, $estado, $responsable);
    }

    public function tipo(): string {
        return 'gratuita';
    }

    public function importe(int $cantidad): int {
        if ($cantidad < 0) {
            throw new InvalidArgumentException('La cantidad no puede ser negativa.');
        }
        return 0;
    }
}
