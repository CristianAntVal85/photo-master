<?php
require_once __DIR__ . '/../src/utils/File.class.php';
require_once __DIR__ . '/../src/utils/entity/asociado.class.php';

$errores = [];
$nombre = '';
$descripcion = '';
$mensaje = '';
$asociado = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreRecibido = $_POST['nombre'] ?? '';
    $descripcionRecibida = $_POST['descripcion'] ?? '';

    if (!is_string($nombreRecibido)) {
        $errores[] = 'El nombre del asociado no es válido.';
    } else {
        $nombre = trim($nombreRecibido);
        if ($nombre === '') {
            $errores[] = 'El nombre del asociado es obligatorio.';
        }
    }

    if (!is_string($descripcionRecibida)) {
        $errores[] = 'La descripción no es válida.';
    } else {
        $descripcion = trim($descripcionRecibida);
    }

    try {
        $logo = new File('logo', ['image/jpeg', 'image/png', 'image/gif']);

        if (empty($errores)) {
            $logo->saveUploadFile(Asociado::RUTA_LOGOS_ASOCIADOS);
            $asociado = new Asociado($nombre, $logo->getFileName(), $descripcion);
            $mensaje = 'El asociado se ha registrado correctamente.';
        }
    } catch (FileException $fileException) {
        $errores[] = $fileException->getMessage();
    }
}

require_once __DIR__ . '/views/Asociados.view.php';
