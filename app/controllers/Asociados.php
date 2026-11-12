<?php

use dwes\app\entity\Asociado;
use dwes\app\exceptions\AppException;
use dwes\app\exceptions\FileException;
use dwes\app\exceptions\QueryException;
use dwes\app\repository\AsociadosRepository;
use dwes\app\utils\File;
use dwes\core\App;

$errores = [];
$nombre = '';
$descripcion = '';
$mensaje = '';
$asociado = null;
$asociados = [];

try {
    $asociadosRepository = new AsociadosRepository();
    $asociados = $asociadosRepository->findAll();

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

        $logo = new File('logo', ['image/jpeg', 'image/png', 'image/gif']);

        if (empty($errores)) {
            $logo->saveUploadFile(Asociado::RUTA_LOGOS_ASOCIADOS);
            $asociado = new Asociado($nombre, $logo->getFileName(), $descripcion);

            // Guardamos el nuevo asociado a través del repositorio
            $asociadosRepository->save($asociado);

            $mensaje = 'El asociado se ha registrado correctamente.';
            $nombre = '';
            $descripcion = '';
            $asociados = $asociadosRepository->findAll();
        }
    }
} catch (FileException $fileException) {
    $errores[] = $fileException->getMessage();
} catch (QueryException $queryException) {
    $errores[] = $queryException->getMessage();
} catch (AppException $appException) {
    $errores[] = $appException->getMessage();
}

require_once __DIR__ . '/../views/Asociados.view.php';
