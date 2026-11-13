<?php

// Ejercicio 9: Validar el correo recibido
$raw = $_POST['email'] ?? null;

if (!is_string($raw)) {
    $errores['email'] = 'Tipo no válido';
} else {
    $email = trim($raw);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if ($email === false) {
        $errores['email'] = 'Correo no válido';
    }
}

var_dump($errores ?? []);
