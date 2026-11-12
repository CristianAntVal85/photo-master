<?php

use dwes\app\entity\Imagen;
use dwes\app\exceptions\AppException;
use dwes\app\exceptions\CategoriaException;
use dwes\app\exceptions\FileException;
use dwes\app\exceptions\NotFoundException;
use dwes\app\exceptions\QueryException;
use dwes\app\repository\ImagenesRepository;
use dwes\app\utils\File;
use dwes\core\App;

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
    App::get('logger')->add('Se ha guardado una imagen: ' . $imagenGaleria->getNombre());

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
