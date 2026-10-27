<?php 
require_once __DIR__ . '/../src/utils/File.class.php';
require_once __DIR__ . '/../src/utils/exceptions/FileException.class.php';
require_once __DIR__ . '/../src/utils/entity/Imagen.class.php';

$errores = [];
$titulo = "";
$descripcion = "";
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $titulo = trim(htmlspecialchars($_POST['titulo']));
        $descripcion = trim(htmlspecialchars($_POST['descripcion']));
        $tiposAceptados = ['image/jpeg', 'image/gif', 'image/png'];
        $imagen = new File('imagen', $tiposAceptados);
        // El nombre 'imagen' coincide con el campo del formulario de galery.view.php.
        $mensaje = "Datos enviados";

        $imagen->saveUploadFile(Imagen::RUTA_IMAGENES_SUBIDAS); 

    } catch (FileException $fileException) {
        $errores[] = $fileException->getMessage();
    }
}

require_once __DIR__ . '/views/galery.view.php';