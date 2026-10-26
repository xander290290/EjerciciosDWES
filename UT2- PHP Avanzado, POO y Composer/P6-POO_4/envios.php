<?php
declare(strict_types=1);

use App\Excepcion\EnvioException;
use App\Modelo\Envio;
use App\Modelo\EnvioNormal;
use App\Modelo\EnvioUrgente;
use App\Modelo\EstadoEnvio;
use App\Repositorio\RepositorioEnviosMemoria;
use App\Servicio\ServicioEnvios;

require_once __DIR__ . '/vendor/autoload.php';

$fallos = 0;
$comprobar = static function (string $descripcion, bool $correcto) use (&$fallos): void {
    echo ($correcto ? '[OK] ' : '[FALLO] ') . $descripcion . PHP_EOL;
    if (!$correcto) {
        $fallos++;
    }
};

$mostrarResumen = static function (array $resumen): void {
    foreach ($resumen as $clave => $valor) {
        echo "  $clave: $valor" . PHP_EOL;
    }
};

$mostrarEtiquetas = static function (ServicioEnvios $servicio, array $envios): void {
    $etiquetas = $servicio->etiquetas($envios);
    if ($etiquetas === []) {
        echo "  Sin resultados" . PHP_EOL;
        return;
    }

    foreach ($etiquetas as $etiqueta) {
        echo "  $etiqueta" . PHP_EOL;
    }
};

$mostrarConsulta = static function (
    string $titulo,
    ServicioEnvios $servicio,
    array $envios,
    array $idsEsperados
) use ($mostrarEtiquetas, $mostrarResumen, $comprobar): void {
    $ids = array_map(static fn (Envio $envio): int => $envio->id(), $envios);
    echo PHP_EOL . "-- $titulo --" . PHP_EOL;
    $mostrarEtiquetas($servicio, $envios);
    $mostrarResumen($servicio->resumir($envios));
    $comprobar(
        'Ids esperados: ' . ($idsEsperados === [] ? 'ninguno' : implode(', ', $idsEsperados)),
        $ids === $idsEsperados
    );
};

$esperarExcepcion = static function (
    string $descripcion,
    string $claseEsperada,
    callable $operacion
) use ($comprobar): void {
    try {
        $operacion();
        $comprobar($descripcion, false);
    } catch (Throwable $excepcion) {
        $comprobar(
            $descripcion . ' (' . $excepcion->getMessage() . ')',
            $excepcion instanceof $claseEsperada
        );
    }
};

$repositorio = new RepositorioEnviosMemoria();
foreach ([
    new EnvioNormal(101, 'Librería Órbita', 1000, EstadoEnvio::Pendiente),
    new EnvioUrgente(102, 'Taller Norte', 1500, EstadoEnvio::Enviado),
    new EnvioNormal(103, 'Café Álamo', 2500, EstadoEnvio::Entregado),
    new EnvioUrgente(104, 'Estudio Prisma', 500, EstadoEnvio::Cancelado),
    new EnvioNormal(105, 'Papelería Sol', 2000, EstadoEnvio::Pendiente),
    new EnvioUrgente(106, 'Órbita Creativa', 1001, EstadoEnvio::Pendiente),
] as $envio) {
    $repositorio->registrar($envio);
}
$servicio = new ServicioEnvios($repositorio);

echo "=== Catálogo inicial ===" . PHP_EOL;
$mostrarEtiquetas($servicio, $repositorio->todos());
$resumenInicial = $servicio->resumir($repositorio->todos());
$mostrarResumen($resumenInicial);
$comprobar('Resumen inicial correcto', $resumenInicial === [
    'cantidad' => 6,
    'peso' => 8501,
    'importeTotal' => 4570,
    'importeActivo' => 3770,
    'pendiente' => 3,
    'enviado' => 1,
    'entregado' => 1,
    'cancelado' => 1,
]);

$consultas = [
    ['Sin filtros', '', null, null, 'precio', [101, 105, 103, 104, 102, 106]],
    ['Texto ÓRBITA', '  ÓRBITA  ', null, null, 'precio', [101, 106]],
    ['Modalidad urgente', '', 'urgente', null, 'precio', [104, 102, 106]],
    ['Estado pendiente', '', null, EstadoEnvio::Pendiente, 'precio', [101, 105, 106]],
    ['ÓRBITA urgente pendiente', 'ÓRBITA', 'urgente', EstadoEnvio::Pendiente, 'precio', [106]],
    ['Texto con espacios interiores', '  ÓRBITA   CREATIVA  ', null, null, 'precio', [106]],
    ['Texto sin coincidencias', 'xyz', null, null, 'precio', []],
    ['Orden por peso', '', null, null, 'peso', [104, 101, 106, 102, 105, 103]],
];

foreach ($consultas as [$titulo, $texto, $modalidad, $estado, $orden, $idsEsperados]) {
    $seleccion = $servicio->consultar($texto, $modalidad, $estado, $orden);
    $mostrarConsulta($titulo, $servicio, $seleccion, $idsEsperados);
}

$idsCatalogo = array_map(
    static fn (Envio $envio): int => $envio->id(),
    $repositorio->todos()
);
$comprobar('Las consultas no alteran el orden del catálogo', $idsCatalogo === [101, 102, 103, 104, 105, 106]);
$comprobar('Las búsquedas devuelven la misma instancia', $repositorio->buscar(101) === $repositorio->buscar(101));
$comprobar('Las búsquedas conservan el resumen inicial', $servicio->resumir($repositorio->todos()) === $resumenInicial);

echo PHP_EOL . '=== Operaciones sobre los mismos envíos ===' . PHP_EOL;
$operaciones = [
    ['Enviar 101', 101, 'enviar', true],
    ['Cancelar 101', 101, 'cancelar', false],
    ['Entregar 101', 101, 'entregar', true],
    ['Enviar 101', 101, 'enviar', false],
    ['Cancelar 105', 105, 'cancelar', true],
    ['Enviar 105', 105, 'enviar', false],
    ['Entregar 102', 102, 'entregar', true],
    ['Cancelar 104', 104, 'cancelar', false],
    ['Entregar 106', 106, 'entregar', false],
    ['Enviar 999', 999, 'enviar', false],
];

foreach ($operaciones as [$descripcion, $id, $metodo, $debeCompletar]) {
    try {
        $servicio->$metodo($id);
        echo "$descripcion: completada" . PHP_EOL;
        $comprobar($descripcion . ' aceptada', $debeCompletar);
    } catch (EnvioException $excepcion) {
        echo "$descripcion: rechazo - {$excepcion->getMessage()}" . PHP_EOL;
        $comprobar($descripcion . ' rechazada', !$debeCompletar);
    }
}

$resumenFinal = $servicio->resumir($repositorio->todos());
$mostrarResumen($resumenFinal);
$comprobar('Resumen final correcto', $resumenFinal === [
    'cantidad' => 6,
    'peso' => 8501,
    'importeTotal' => 4570,
    'importeActivo' => 3180,
    'pendiente' => 1,
    'enviado' => 0,
    'entregado' => 3,
    'cancelado' => 2,
]);
$pendientesFinales = $servicio->consultar('', null, EstadoEnvio::Pendiente);
$comprobar(
    'Solo queda pendiente el envío 106',
    array_map(static fn (Envio $envio): int => $envio->id(), $pendientesFinales) === [106]
);
$comprobar('El catálogo conserva sus seis envíos', count($repositorio->todos()) === 6);

echo PHP_EOL . '=== Validaciones y límites ===' . PHP_EOL;
foreach ([0, -1] as $idInvalido) {
    $esperarExcepcion(
        "Rechaza id $idInvalido al construir",
        InvalidArgumentException::class,
        static fn () => new EnvioNormal($idInvalido, 'Cliente', 1, EstadoEnvio::Pendiente)
    );
}
foreach (['', '   '] as $clienteInvalido) {
    $esperarExcepcion(
        'Rechaza cliente vacío',
        InvalidArgumentException::class,
        static fn () => new EnvioNormal(201, $clienteInvalido, 1, EstadoEnvio::Pendiente)
    );
}
foreach ([0, -1, 20001] as $pesoInvalido) {
    $esperarExcepcion(
        "Rechaza peso $pesoInvalido",
        InvalidArgumentException::class,
        static fn () => new EnvioNormal(202, 'Cliente', $pesoInvalido, EstadoEnvio::Pendiente)
    );
}

$clienteNormalizado = new EnvioNormal(203, '  Cliente   con  espacios  ', 1, EstadoEnvio::Pendiente);
$comprobar('Solo elimina los espacios exteriores del cliente', $clienteNormalizado->cliente() === 'Cliente   con  espacios');

foreach ([
    [1, 470, 800],
    [1000, 470, 800],
    [1001, 590, 1000],
    [20000, 2750, 4600],
] as [$peso, $tarifaNormal, $tarifaUrgente]) {
    $normal = new EnvioNormal(301, 'Normal', $peso, EstadoEnvio::Pendiente);
    $urgente = new EnvioUrgente(302, 'Urgente', $peso, EstadoEnvio::Pendiente);
    $comprobar(
        "Tarifas correctas para $peso gramos",
        $normal->tarifa() === $tarifaNormal && $urgente->tarifa() === $tarifaUrgente
    );
}

$instanciaOriginal = $repositorio->buscar(101);
$esperarExcepcion(
    'Rechaza el registro del id duplicado sin alterar el catálogo',
    EnvioException::class,
    static fn () => $repositorio->registrar(
        new EnvioUrgente(101, 'Duplicado', 1, EstadoEnvio::Pendiente)
    )
);
$comprobar(
    'El envío 101 y el tamaño del catálogo siguen intactos',
    $repositorio->buscar(101) === $instanciaOriginal && count($repositorio->todos()) === 6
);
$comprobar('El id 999 ausente devuelve null', $repositorio->buscar(999) === null);
$esperarExcepcion(
    'Rechaza buscar el id 0',
    InvalidArgumentException::class,
    static fn () => $repositorio->buscar(0)
);
$esperarExcepcion(
    'Rechaza enviar el id 0',
    InvalidArgumentException::class,
    static fn () => $servicio->enviar(0)
);

foreach ([
    ['modalidad desconocida', static fn (ServicioEnvios $s) => $s->consultar('', 'express')],
    ['orden desconocido', static fn (ServicioEnvios $s) => $s->consultar('', null, null, 'cliente')],
] as [$descripcion, $consultaInvalida]) {
    $esperarExcepcion(
        "Rechaza $descripcion",
        InvalidArgumentException::class,
        static fn () => $consultaInvalida($servicio)
    );
}

$repositorioVacio = new RepositorioEnviosMemoria();
$servicioVacio = new ServicioEnvios($repositorioVacio);
$comprobar('La consulta válida vacía devuelve []', $servicioVacio->consultar() === []);
$comprobar('etiquetas([]) devuelve []', $servicioVacio->etiquetas([]) === []);
$comprobar('resumir([]) contiene ocho valores a cero', $servicioVacio->resumir([]) === [
    'cantidad' => 0,
    'peso' => 0,
    'importeTotal' => 0,
    'importeActivo' => 0,
    'pendiente' => 0,
    'enviado' => 0,
    'entregado' => 0,
    'cancelado' => 0,
]);
$esperarExcepcion(
    'Valida modalidad en un repositorio vacío',
    InvalidArgumentException::class,
    static fn () => $servicioVacio->consultar('', 'express')
);
$esperarExcepcion(
    'Valida orden en un repositorio vacío',
    InvalidArgumentException::class,
    static fn () => $servicioVacio->consultar('', null, null, 'cliente')
);

echo PHP_EOL . ($fallos === 0 ? 'Todas las comprobaciones han terminado correctamente.' : "$fallos comprobación(es) han fallado.") . PHP_EOL;
exit($fallos === 0 ? 0 : 1);
