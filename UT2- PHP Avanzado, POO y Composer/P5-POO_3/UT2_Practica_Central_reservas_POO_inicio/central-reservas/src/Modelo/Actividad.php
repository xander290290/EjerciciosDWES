<?php
declare(strict_types=1);

// TODO M6. Implementa la clase abstracta Actividad, sus reglas y las operaciones final.
abstract class Actividad implements Reservable{
    use GeneraEtiqueta;

    public function __construct(
        private readonly int $id,
        private readonly string $nombre,
        private readonly int $capacidad,
        private int $ocupadas,
        private readonly EstadoActividad $estado,
        private readonly ?Responsable $responsable
    ){
        if ($id<0){
            throw new InvalidArgumentException('Id inválido');
        }
        if (trim($nombre)===''){
            throw new InvalidArgumentException('Nombre vacio');
        }
        if ($capacidad<0){
            throw new InvalidArgumentException('Capacidad menor que 1');
        }
        if ($ocupadas<0 || $ocupadas > $capacidad){
            throw new InvalidArgumentException('Numero de ocupadas incorrecto');
        }
    }

    public function id(){
        return $this->id;
    }

    public function nombre(){
        return $this->nombre;
    }

    public function capacidad(){
        return $this->capacidad;
    }

    public function ocupadas(){
        return $this->ocupadas;
    }

    public function estado(){
        return $this->estado;
    }

    public function responsable(){
        return $this->responsable;
    }

    public function PlazasLibres(): int{
        return $this->capacidad - $this->ocupadas;
    }

    abstract function tipo(): string;
    abstract function importe(int $cantidad ): int;

    public final function reservar(int $cantidad): void {
        if ($cantidad<1){
            throw new InvalidArgumentException('Cantidad no permitida');
        } elseif ($this->estado === EstadoActividad::Cerrada) {
            throw new ReservaException('Estado de actividad cerrado');
        } elseif ($cantidad > $this->PlazasLibres()) {
            throw new PlazasInsuficientesException('Plazas insuficientes');
        }
        $this->ocupadas = $this->ocupadas + $cantidad;
    }

    public final function cancelar(int $cantidad): void {
        if ($cantidad < 1){
            throw new InvalidArgumentException('Cantidad no permitida');
        } elseif ($cantidad > $this->ocupadas) {
            throw new ReservaException('Cantidad mayor a plazas ocupadas');
        }
        $this->ocupadas = $this->ocupadas - $cantidad;
    }
}
