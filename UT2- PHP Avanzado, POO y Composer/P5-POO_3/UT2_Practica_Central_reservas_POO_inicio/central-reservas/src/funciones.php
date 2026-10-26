<?php
declare(strict_types=1);

function entrada(array $origen, string $clave, string $defecto = ''): string
{
    // TODO F1. Lee solo cadenas y aplica el valor por defecto.
    return isset($origen[$clave]) && is_string($origen[$clave]) ? $origen[$clave] : $defecto;
}

function enteroPositivo(string $valor): int
{
    // TODO F2. Valida antes de convertir; rechaza con InvalidArgumentException.
    $entero = filter_var($valor, FILTER_VALIDATE_INT);
    if ($entero === false) {
        throw new InvalidArgumentException('Debe indicarse un número entero positivo.');
    }
    return $entero;
}

function limpiarEspacios(string $texto): string
{
    return preg_replace('/\s+/u', ' ', trim($texto)) ?? '';
}

function normalizar(string $texto): string
{
    return mb_strtolower(limpiarEspacios($texto), 'UTF-8');
}

function buscarPorId(array $actividades, int $id): ?Actividad
{
    // TODO F3. Usa array_find con un callback tipado.
    return array_find($actividades, 
            fn (Actividad $a): bool => $a->id() === $id);
}

function filtrarActividades(
    array $actividades,
    string $texto,
    string $tipo,
    ?EstadoActividad $estado,
    bool $soloDisponibles
): array {
    $buscado = normalizar($texto);

    $resultado = array_filter(
        $actividades,
        fn(Actividad $a): bool =>
            ($buscado === '' || str_contains(normalizar($a->nombre()), $buscado))
            && ($tipo === '' || $a->tipo() === $tipo)
            && ($estado === null || $a->estado() === $estado)
            && (!$soloDisponibles
                || ($a->estado() === EstadoActividad::Abierta && $a->plazasLibres() > 0))
    );

    return array_values($resultado);
}

function ordenarActividades(array $actividades, string $orden): array
{
    // TODO F5. Ordena una copia con usort y desempata por id.
    $ordenadas = $actividades;

    usort($ordenadas, function (Actividad $a, Actividad $b) use ($orden): int {
        $comparacion = match ($orden) {
            'libres' => $a->PlazasLibres() <=> $b->PlazasLibres(),
            'nombre' => strcmp(normalizar($a->nombre()), normalizar($b->nombre())),
            default => 0,
        };

        if ($comparacion === 0) {
            return $a->id() <=> $b->id();
        }

        return $comparacion;
    });

    return $ordenadas;
}

function transformarActividades(array $actividades, callable $transformacion): array
{
    return array_map($transformacion, $actividades);
}

function etiquetasActividades(array $actividades, string $prefijo = 'Actividad: '): array
{
    return transformarActividades(
        $actividades,
        function (Actividad $a) use ($prefijo): string {
            return $a->etiqueta($prefijo);
        }
    );
}

function resumirActividades(array $actividades): array
{
    // TODO F7. Calcula las cinco magnitudes con array_reduce.
    return array_reduce(
        $actividades,
        fn(array $acc, Actividad $a): array => [
            'cantidad'  => $acc['cantidad'] + 1,
            'capacidad' => $acc['capacidad'] + $a->capacidad(),
            'ocupadas'  => $acc['ocupadas'] + $a->ocupadas(),
            'libres'    => $acc['libres'] + $a->plazasLibres(),
            'importe'   => $acc['importe'] + $a->importe($a->ocupadas()),
        ],
        ['cantidad' => 0, 'capacidad' => 0, 'ocupadas' => 0, 'libres' => 0, 'importe' => 0]
    );
}

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function euros(int $centimos): string
{
    return number_format($centimos / 100, 2, ',', '.') . ' €';
}
