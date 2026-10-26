<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/cargar.php';
require_once __DIR__ . '/../src/datos.php';
require_once __DIR__ . '/../src/funciones.php';

$actividades = crearActividades();
$avisos = [];
$mensaje = '';
$error = '';
$cierre = '';

// INICIO E1
$texto = entrada($_GET, 'q');

$tipo = entrada($_GET, 'tipo');
if (!in_array($tipo, ['', 'gratuita', 'pago'], true)) {
    $avisos[] = 'El tipo indicado no es válido; se muestran todos.';
    $tipo = '';
}

$estadoTexto = entrada($_GET, 'estado');
$estado = null;
if ($estadoTexto !== '') {
    $estado = EstadoActividad::tryFrom($estadoTexto);
    if ($estado === null) {
        $avisos[] = 'El estado indicado no es válido; no se aplica restricción.';
        $estadoTexto = '';
    }
}

$soloDisponibles = entrada($_GET, 'disponibles') === '1';

$orden = entrada($_GET, 'orden', 'nombre');
if (!in_array($orden, ['nombre', 'libres'], true)) {
    $orden = 'nombre';
}

$idConsulta = entrada($_GET, 'id');
// FIN E1

if (isset($_GET['accion'])) {
    // INICIO E2
    try {
        $accion = entrada($_GET, 'accion');
        if (!in_array($accion, ['reservar', 'cancelar'], true)) {
            throw new InvalidArgumentException('La acción solicitada no es válida.');
        }

        $idActividad = enteroPositivo(entrada($_GET, 'idActividad'));
        $cantidad    = enteroPositivo(entrada($_GET, 'cantidad'));

        $actividad = buscarPorId($actividades, $idActividad);
        if ($actividad === null) {
            throw new ReservaException('La actividad solicitada no existe.');
        }

        if ($accion === 'reservar') {
            $actividad->reservar($cantidad);
        } else {
            $actividad->cancelar($cantidad);
        }
        $importe = $actividad->importe($cantidad);

        $mensaje = ($accion === 'reservar' ? 'Reserva realizada' : 'Cancelación realizada')
            . '. Importe: ' . euros($importe);
    } catch (PlazasInsuficientesException $e) {
        $error = 'No hay plazas suficientes: ' . $e->getMessage();
    } catch (ReservaException $e) {
        $error = 'No se pudo completar la operación: ' . $e->getMessage();
    } catch (InvalidArgumentException $e) {
        $error = 'Datos no válidos: ' . $e->getMessage();
    } finally {
        $cierre = 'Procesamiento de la operación finalizado.';
    }
    // FIN E2
}

// INICIO E3
$ficha = null;
if ($idConsulta !== '') {
    $idFicha = filter_var($idConsulta, FILTER_VALIDATE_INT);
    if ($idFicha === false || $idFicha < 1) {
        $avisos[] = 'El id de ficha no es válido.';
    } else {
        $ficha = buscarPorId($actividades, $idFicha);
    }
}

$visibles = filtrarActividades($actividades, $texto, $tipo, $estado, $soloDisponibles);
$visibles = ordenarActividades($visibles, $orden);
$resumen = resumirActividades($visibles);
$etiquetas = etiquetasActividades($visibles);
// FIN E3

require __DIR__ . '/../vista/catalogo.php';
