<?php

declare(strict_types=1);

function limpiarEspacios(string $texto): string
{
    // TODO 1: limpiar extremos y agrupar espacios consecutivos.
    return preg_replace('/\s+/', ' ',trim($texto)); //Sustituye espacios y elimina espacios antes y después
} //Hecho

function normalizarBusqueda(string $texto): string
{
    // REVISAR: ¿funciona con PÁDEL y ÓRBITA?
    return mb_strtolower(limpiarEspacios($texto), 'UTF-8'); //Combierte el string a minuscula y distinge tildes por UTF-8
} //Hecho

function obtenerCategorias(array $actividades): array
{
    // TODO 2: extraer categorías sin duplicados en orden de aparición.
    $catValorColumna = array_column($actividades, 'categoria'); //Extrae los valores de la columna
    $catSinDuplicado = array_unique($catValorColumna); //Elimina los duplicados
    $catConEntiqueta = array_map(fn (int $c): string => "Cat: $c", $catSinDuplicado); //Añade etiqueta a cada valor
    return $catConEntiqueta;
} //Hecho

function categoriaValida(string $categoria, array $categorias): bool
{
    return $categoria === '' || (bool) array_search($categoria, $categorias, true);
} //No se

function plazasOcupadas(array $reservas, int $actividadId): int
{
    // TODO 5: sumar plazas de reservas confirmadas de esta actividad.
    $confirmado = array_filter(
        $reservas,
        fn (int $r): bool => $r['estado'] === 'confirmada' && $r['id'] === $actividadId
        ); //Filtra por estado confirmado y si id
    $campoPlazas = array_reduce($confirmado, fn (int $a, int $b): int => $a[plazas] + $b[plazas], 0); //Suma las plazas del array confirmado
    return 0;
} //No se

// Función facilitada: añade los cálculos a una copia de cada actividad.
function prepararActividades(array $actividades, array $reservas): array
{
    return array_map(
        function (array $actividad) use ($reservas): array {
            $actividad['ocupadas'] = plazasOcupadas($reservas, $actividad['id']);
            $actividad['libres'] = $actividad['capacidad'] - $actividad['ocupadas'];

            return $actividad;
        },
        $actividades
    );
}

function filtrarActividades(
    array $actividades,
    string $texto,
    string $categoria,
    bool $soloConPlazas
): array

{
    // TODO 3: filtrar por nombre, categoría y plazas libres.
    if ($texto === '' && $categoria === '') {
        return $actividades;
    }

    if ($soloConPlazas){
        $actividadesConPlazas = array_filter($actividades, fn (): bool => $a);
    }
    return [];
} //No se

function ordenarActividades(array $actividades, string $orden): array
{
    // TODO 4: ordenar una copia según el criterio y desempatar por id.
    usort($actividades, fn (array $a, array $b): int => $p);
    return $actividades;
} //No se

function resumirActividades(array $actividades): array
{
    return [
        'cantidad' => count($actividades),
        'capacidad' => count($actividades), // REVISAR: cuenta actividades, no plazas
        'ocupadas' => array_reduce(
            $actividades,
            fn(int $s, array $a): int => $s + $a['ocupadas'],
            0
        ),
        'libres' => 0, // TODO 6: sumar plazas libres
        'hayCompletas' => array_any(), // TODO 7: comprobar si alguna está completa
        'todasConPlazas' => false, // TODO 8: comprobar si todas tienen plazas
    ];
} //No se

// Función facilitada: permite pasar una función como dato.
function transformarNombres(array $nombres, callable $callback): array
{
    return array_map($callback, $nombres);
}

function generarEtiquetas(array $actividades, string $prefijo = 'Actividad: '): array
{
    // TODO 9: extraer nombres y usar una closure que capture el prefijo.
    return [];
}

// Función facilitada. La entrada web valida el id antes de llamar.
function normalizarId(int|string $id): int
{
    return (int) $id;
}

function buscarPorId(array $actividades, int|string $id): ?array
{
    // TODO 10: buscar por id en todas las actividades; id no es índice.
    return array_find(
        $actividades
    );
} //Sin completar

function monitorVisible(?string $monitor): string
{
    // TODO 11: resolver el caso de monitor null.
    return '';
}

function inicioNombre(string $nombre): string
{
    return substr(limpiarEspacios($nombre), 0, 3);
}

function codigoValido(string $codigo): bool
{
    return preg_match('/DEP-[0-9]+-[0-9]+/', $codigo) === 1;
}
