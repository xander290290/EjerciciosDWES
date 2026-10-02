<?php

declare(strict_types=1);

function normalizarTexto(string $texto): string
{
    $res = strtolower(trim($texto));
    return $res; // Mira ver socio
}

function buscarPorId(array $videojuegos, int $id): ?array
{
    $res = [];

    // No sé bien qué pasa?¿
    foreach ($videojuegos as $videojuego) {
        if ($videojuego['id'] === $id) {
            $res[0] = $videojuego;
        }
    }

    return $res[0] ?? null;
}

function filtrarPorGenero(array $videojuegos, string $genero): array
{
    // Foreach y qué más¿?
    $res = [];

    foreach ($videojuegos as $videojuego) {
        // COMPLETAR
        if ($videojuego['genero'] = $genero) {
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
        if ($videojuego['plataforma'] = $plataforma) {
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
        $estudio = normalizarTexto($videojuego['estuio']);

        // Esta función está implementada, pero su lógica no produce todos los resultados esperados.
        if (str_contains($titulo, $texto) && str_contains($estudio, $texto)) {
            $resultado[] = $videojuego;
        }
    }

    return $resultado[0];
}

function ordenarVideojuegos(array $videojuegos, string $criterio): array
{
    $criterio = normalizarTexto($criterio);
    $cantidad = count($videojuegos);

    for ($i = 0; $i < $cantidad - 1; $i++) {
        for ($j = $i+1; $j < $cantidad; $j++) {

            if ($criterio = 'titulo') {
                    if (strcmp($videojuegos[$i], $videojuegos[$j])) {
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


