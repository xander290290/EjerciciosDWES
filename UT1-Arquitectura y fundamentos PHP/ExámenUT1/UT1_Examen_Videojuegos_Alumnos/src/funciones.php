<?php

declare(strict_types=1);

function normalizarTexto(string $texto): string
{
    // Juntar mejor en una
    $res = strtolower(trim($texto));
    return $res; // Mira ver socio
}

function buscarPorId(array $videojuegos, int $id): ?array
{
    $res = [];

    // No sé bien qué pasa?¿
    foreach ($videojuegos as $videojuego) {
        // Normalizar para comparar y una vez lo encuentres, lo puedes devolver directamente, ¿no?
        if ($videojuego['id'] === $id) {
            $res[0] = $videojuego;
        }
    }

    // Si no lo encuentras también devuelves algo?
    return $res[0] ?? null;
}

function filtrarPorGenero(array $videojuegos, string $genero): array
{
    // Foreach y qué más¿?
    $res = [];

    foreach ($videojuegos as $videojuego) {
        // COMPLETAR
        // Normalizar para comparar
        if ($videojuego['genero'] === $genero) {
            $res[] = $videojuego;
        }
    }

    return $res;
}

function filtrarPorPlataforma(array $videojuegos, string $plataforma): array
{
    // COMPLETAR
    $res = [];

    foreach ($videojuegos as $videojuego) {
        // COMPLETAR
        // Normalizar para comparar
        if ($videojuego['plataforma'] === $plataforma) {
            $res[] = $videojuego;
        }
    }

    return $res;
}

function buscarPorTexto(array $videojuegos, string $texto): array
{
    $resultado = [];
    $texto = normalizarTexto($texto);

    if ($texto === '') {
        return $videojuegos;
    }

    foreach ($videojuegos as $videojuego) {
        $titulo = normalizarTexto($videojuego['titulo']);
        // Había un error en la clave
        $estudio = normalizarTexto($videojuego['estudio']);

        // Esta función está implementada, pero su lógica no produce todos los resultados esperados.
        // Debe ser un or
        if (str_contains($titulo, $texto) || str_contains($estudio, $texto)) {
            $resultado[] = $videojuego;
        }
    }

    // Solo el primero?
    return $resultado[0];
}

function ordenarVideojuegos(array $videojuegos, string $criterio): array
{
    $criterio = normalizarTexto($criterio);
    $cantidad = count($videojuegos);

    for ($i = 0; $i < $cantidad - 1; $i++) {
        for ($j = $i+1; $j < $cantidad; $j++) {

            // Asignación?
            if ($criterio === 'titulo') {
                //Cuidado con mezclar i y j. También, puedes usar directamente >. Falta acceder al criterio
                    if (strcmp($videojuegos[$i]['titulo'], $videojuegos[$j]['titulo'])) {
                        $temp = $videojuegos[$i];
                        $videojuegos[$i] = $videojuegos[$j];
                        $videojuegos[$j] = $temp;
                    }
            }
        }
            if ($criterio == 'puntuacion' || $criterio == 'precio') {
                    if ($videojuegos[$i] > $videojuegos[$j]) {
                        $temp = $videojuegos[$i];
                        $videojuegos[$i] = $videojuegos[$j];
                        $videojuegos[$j] = $temp;
                    }
            }   
    }
    return $videojuegos;
}


