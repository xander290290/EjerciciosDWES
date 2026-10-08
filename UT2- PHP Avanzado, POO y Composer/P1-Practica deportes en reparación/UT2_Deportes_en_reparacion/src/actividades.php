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
    $catLista = array_values($catSinDuplicado);
    return $catLista;
} //Hecho

function categoriaValida(string $categoria, array $categorias): bool
{
    return $categoria === '' || array_search($categoria, $categorias, true) !== false; //Se añade que no sea false porque 0 es una opcion valida de search
} //Hecho

function plazasOcupadas(array $reservas, int $actividadId): int
{
    // TODO 5: sumar plazas de reservas confirmadas de esta actividad.
    $confirmado = array_filter(
        $reservas,
        fn (array $r): bool => $r['estado'] === 'confirmada' && $r['actividadId'] === $actividadId
        ); //Filtra por estado confirmado y su id
    $campoPlazas = array_reduce($confirmado, fn ( int $a, array $b): int => $a + $b['plazas'], 0); //Suma las plazas del array confirmado
    return $campoPlazas;
} //Hecho

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
} //Añade a cada actividad del array actividades el valor de ocupadas y libres gracias a la funcion anterior, preparando un nuevo array con estos valores

function filtrarActividades(
    array $actividades,
    string $texto,
    string $categoria,
    bool $soloConPlazas
): array

{   // TODO 3: filtrar por nombre, categoría y plazas libres.
    if ($texto !== '') {
        $actividades = array_filter($actividades, fn (array $a): bool => str_contains(normalizarBusqueda($a['nombre']), normalizarBusqueda($texto)));
    }

    if ($categoria !== '') {
        $actividades = array_filter($actividades, fn (array $a): bool => normalizarBusqueda($a['categoria']) === normalizarBusqueda($categoria));
    }
    
    if ($soloConPlazas){
        $actividades = array_filter($actividades, fn (array $a): bool => $a['libres']>0);
    }
    return $actividades;
} //Hecho. El profesor lo resolvio añadiendo todas las condiciones dentro de la funcion de un array_filter

function ordenarActividades(array $actividades, string $orden): array
{
    // TODO 4: ordenar una copia según el criterio y desempatar por id.
    usort($actividades, function (array $a, array $b) use ($orden): int {
        if ($orden === 'libres') {
            $comparacion = $a['capacidad'] <=> $b['capacidad'];
        } elseif ($orden === 'nombre') {
            $comparacion = $a['nombre'] <=> $b['nombre'];
        }

        if ($comparacion === 0) {
            $comparacion = $a['id'] <=> $b['id'];
        }
        return $comparacion;
});
    return $actividades;
} //Hecho, los nombres ya estan normalizados

function resumirActividades(array $actividades): array
{
    return [
        'cantidad' => count($actividades),
        'capacidad' => array_reduce(
            $actividades,
            fn(int $c, array $a): int => $c + $a['capacidad'],
            0
        ),
        'ocupadas' => array_reduce(
            $actividades,
            fn(int $s, array $a): int => $s + $a['ocupadas'],
            0
        ),
        'libres' => array_reduce(
            $actividades,
            fn(int $s, array $a): int => $s + $a['libres'],
            0
        ),
        'hayCompletas' => array_any(
            $actividades,
            fn(array $a): bool => $a['libres'] === 0,
        ), // TODO 7: comprobar si alguna está completa
        'todasConPlazas' => array_all(
            $actividades,
            fn(array $a): bool => $a['libres'] > 0,
        ), // TODO 8: comprobar si todas tienen plazas
    ];
} //Hecho

// Función facilitada: permite pasar una función como dato.
function transformarNombres(array $nombres, callable $callback): array
{
    return array_map($callback, $nombres);
}

function generarEtiquetas(array $actividades, string $prefijo = 'Actividad: '): array
{
    // TODO 9: extraer nombres y usar una closure que capture el prefijo.
    $nombres = array_column($actividades, 'nombre');
    $res = transformarNombres(
        $nombres,
        function (string $nombres) use ($prefijo) {
            return $prefijo . limpiarEspacios($nombres);
        }
    );
    return $res;
} //Recoge valores de una columna y añade prefijos como array_map

// Función facilitada. La entrada web valida el id antes de llamar.
function normalizarId(int|string $id): int
{
    return (int) $id;
}

function buscarPorId(array $actividades, int|string $id): ?array
{
    // TODO 10: buscar por id en todas las actividades; id no es índice.
    $idNormalizado = normalizarId($id); //Normaliza el id para que sea de tipo int
    return array_find(
        $actividades,
        fn(array $a) => $a['id'] === $idNormalizado //Comprueba que el id coincida para devolver el primero que encuentre
    );
} //Hecho

function monitorVisible(?string $monitor): string
{
    // TODO 11: resolver el caso de monitor null.
    return ($monitor ?? 'Monitor pendiente'); ///Comprueba que monitor no sea null, y si lo es devuelve monitor pendiente
} ///Hecho

function inicioNombre(string $nombre): string
{
    return mb_substr(limpiarEspacios($nombre), 0, 3, 'UTF-8'); //Se usa mb_substr para contar caracteres especiales
}

function codigoValido(string $codigo): bool
{
    return preg_match('/^DEP-\d{4}-\d{4}$/', $codigo) === 1;
}
