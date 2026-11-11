<?php

require_once __DIR__ . '/../../src/utils/File.class.php';
require_once __DIR__ . '/../../src/utils/exceptions/FileException.class.php';
require_once __DIR__ . '/../../src/utils/exceptions/QueryException.php';
require_once __DIR__ . '/../../src/exceptions/AppException.class.php';
require_once __DIR__ . '/../../src/exceptions/CategoriaException.php';
require_once __DIR__ . '/../../src/exceptions/NotFoundException.php';
require_once __DIR__ . '/../../src/utils/entity/Imagen.class.php';
require_once __DIR__ . '/../../src/repository/ImagenesRepository.php';

$errores = [];
$titulo = trim(htmlspecialchars($_POST['titulo'] ?? ''));
$descripcion = trim(htmlspecialchars($_POST['descripcion'] ?? ''));
$mensaje = '';

try {
    App::getConnection();
    $imagenesRepository = new ImagenesRepository();
    $categoria = trim(htmlspecialchars($_POST['categoria'] ?? ''));

    if ($categoria === '') {
        throw new CategoriaException();
    }

    $tiposAceptados = ['image/jpeg', 'image/gif', 'image/png'];
    $imagen = new File('imagen', $tiposAceptados);
    $imagen->saveUploadFile(Imagen::RUTA_IMAGENES_SUBIDAS);

    $imagenGaleria = new Imagen($imagen->getFileName(), $descripcion, $categoria);
    $imagenesRepository->guarda($imagenGaleria);

    App::get('router')->redirect('galeria');
    exit;
} catch (FileException $fileException) {
    $errores[] = $fileException->getMessage();
} catch (QueryException $queryException) {
    $errores[] = $queryException->getMessage();
} catch (NotFoundException $notFoundException) {
    $errores[] = $notFoundException->getMessage();
} catch (AppException $appException) {
    $errores[] = $appException->getMessage();
} catch (CategoriaException $categoriaException) {
    $errores[] = 'No se ha seleccionado una categoría válida';
}

require __DIR__ . '/galery.php';
