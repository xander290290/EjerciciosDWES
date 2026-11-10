<?php
declare(strict_types=1);

const MIME_CARTEL = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/webp' => 'webp',
];

const TAMANO_MAXIMO_CARTEL = 2097152;
const TAMANO_MAXIMO_POST = 8388608;

function escapar(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function directorioCarteles(): string
{
    return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'carteles';
}

function nombreCartelValido(mixed $nombre): bool
{
    return is_string($nombre)
        && preg_match('/\A[a-f0-9]{32}\.(jpg|png|webp)\z/', $nombre) === 1;
}

function inspeccionarCartel(mixed $nombre): ?array
{
    if (!nombreCartelValido($nombre)) {
        return null;
    }

    $ruta = directorioCarteles() . DIRECTORY_SEPARATOR . $nombre;
    if (!is_file($ruta) || !is_readable($ruta)) {
        return null;
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($ruta);
    if (!is_string($mime) || !isset(MIME_CARTEL[$mime])) {
        return null;
    }

    return ['nombre' => $nombre, 'ruta' => $ruta, 'mime' => $mime];
}

function listarCarteles(): array|false
{
    $rutas = glob(directorioCarteles() . DIRECTORY_SEPARATOR . '*');
    if ($rutas === false) {
        return false;
    }

    $carteles = [];
    foreach ($rutas as $ruta) {
        $cartel = inspeccionarCartel(basename($ruta));
        if ($cartel !== null) {
            $carteles[] = $cartel;
        }
    }

    return $carteles;
}

function errorRecepcion(int $codigo): string
{
    return match ($codigo) {
        UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'El archivo supera el límite de recepción de PHP.',
        UPLOAD_ERR_PARTIAL => 'La recepción del archivo quedó incompleta.',
        UPLOAD_ERR_NO_TMP_DIR, UPLOAD_ERR_CANT_WRITE => 'PHP no pudo guardar temporalmente el archivo.',
        UPLOAD_ERR_EXTENSION => 'Una extensión de PHP detuvo la recepción del archivo.',
        default => 'Se produjo un error al recibir el archivo.',
    };
}

function recibirImagen(array $archivos): array
{
    if (!array_key_exists('imagen', $archivos)) {
        return ['archivo' => null, 'error' => null, 'sinArchivo' => true];
    }

    $archivo = $archivos['imagen'];
    if (
        !is_array($archivo)
        || !array_key_exists('error', $archivo)
        || !array_key_exists('size', $archivo)
        || !array_key_exists('tmp_name', $archivo)
        || !is_int($archivo['error'])
        || !is_int($archivo['size'])
        || !is_string($archivo['tmp_name'])
    ) {
        return ['archivo' => null, 'error' => 'La estructura del archivo recibido no es válida.', 'sinArchivo' => false];
    }

    if ($archivo['error'] === UPLOAD_ERR_NO_FILE) {
        return ['archivo' => null, 'error' => null, 'sinArchivo' => true];
    }

    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        return ['archivo' => null, 'error' => errorRecepcion($archivo['error']), 'sinArchivo' => false];
    }

    return ['archivo' => $archivo, 'error' => null, 'sinArchivo' => false];
}

function inspeccionarImagen(array $archivo): array
{
    if ($archivo['size'] < 1 || $archivo['size'] > TAMANO_MAXIMO_CARTEL) {
        return ['archivo' => null, 'error' => 'La imagen debe ocupar entre 1 byte y 2 MiB.'];
    }

    $temporal = $archivo['tmp_name'];
    if (!is_file($temporal) || !is_readable($temporal)) {
        return ['archivo' => null, 'error' => 'No se puede leer el archivo recibido.'];
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($temporal);
    if (!is_string($mime) || !isset(MIME_CARTEL[$mime])) {
        return ['archivo' => null, 'error' => 'El archivo no tiene un formato de imagen permitido.'];
    }

    $archivo['extension'] = MIME_CARTEL[$mime];
    $archivo['mime'] = $mime;
    return ['archivo' => $archivo, 'error' => null];
}

function excedeLimitePost(): bool
{
    $longitud = $_SERVER['CONTENT_LENGTH'] ?? null;
    if (!is_string($longitud) || !ctype_digit($longitud)) {
        return false;
    }

    $longitudNormalizada = ltrim($longitud, '0');
    $limite = (string) TAMANO_MAXIMO_POST;

    return strlen($longitudNormalizada) > strlen($limite)
        || (
            strlen($longitudNormalizada) === strlen($limite)
            && strcmp($longitudNormalizada, $limite) > 0
        );
}

function prepararDestino(string $extension, ?string $nombreAnterior): array
{
    $directorio = directorioCarteles();
    if (!is_dir($directorio) || !is_writable($directorio)) {
        return ['destino' => null, 'error' => 'No se puede guardar la imagen en este momento.'];
    }

    for ($intento = 0; $intento < 5; $intento++) {
        try {
            $nombre = bin2hex(random_bytes(16)) . '.' . $extension;
        } catch (Random\RandomException) {
            return ['destino' => null, 'error' => 'No se pudo preparar un nombre seguro para la imagen.'];
        }

        $ruta = $directorio . DIRECTORY_SEPARATOR . $nombre;
        if ($nombre !== $nombreAnterior && !file_exists($ruta)) {
            return ['destino' => ['nombre' => $nombre, 'ruta' => $ruta], 'error' => null];
        }
    }

    return ['destino' => null, 'error' => 'No se pudo preparar un destino disponible para la imagen.'];
}

function guardarImagen(array $archivo, ?string $nombreAnterior): array
{
    $preparacion = prepararDestino($archivo['extension'], $nombreAnterior);
    if ($preparacion['error'] !== null) {
        return ['cartel' => null, 'error' => $preparacion['error']];
    }

    $destino = $preparacion['destino'];
    if (!move_uploaded_file($archivo['tmp_name'], $destino['ruta'])) {
        return ['cartel' => null, 'error' => 'No se pudo guardar la imagen recibida.'];
    }

    return ['cartel' => $destino, 'error' => null];
}
