<?php
if (session_start() === false) {
    throw new RuntimeException('No se pudo iniciar la sesión del formulario.');
}

$errores = [];
$mensaje = '';
$captchaImageToken = bin2hex(random_bytes(8));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $captchaRecibido = $_POST['captcha'] ?? '';

    if (!is_string($captchaRecibido) || trim($captchaRecibido) === '') {
        $errores[] = 'Introduzca el código de seguridad.';
    } elseif (
        !isset($_SESSION['captchaGenerado'])
        || !is_string($_SESSION['captchaGenerado'])
        || !hash_equals($_SESSION['captchaGenerado'], trim($captchaRecibido))
    ) {
        $errores[] = '¡Ha introducido un código de seguridad incorrecto! Inténtelo de nuevo.';
        unset($_SESSION['captchaGenerado']);
    } else {
        $mensaje = 'El código de seguridad es correcto.';
        unset($_SESSION['captchaGenerado']);
    }
}

if (session_write_close() === false) {
    throw new RuntimeException('No se pudo guardar la sesión del formulario.');
}

require_once __DIR__ . '/views/contact.view.php';
