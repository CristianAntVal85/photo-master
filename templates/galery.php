<?php

require_once __DIR__ . '/../core/App.php';
require_once __DIR__ . '/../src/utils/File.class.php';
require_once __DIR__ . '/../src/utils/exceptions/FileException.class.php';
require_once __DIR__ . '/../src/utils/exceptions/QueryException.php';
require_once __DIR__ . '/../src/exceptions/AppException.class.php';
require_once __DIR__ . '/../src/exceptions/CategoriaException.php';
require_once __DIR__ . '/../src/exceptions/NotFoundException.php';
require_once __DIR__ . '/../src/utils/entity/Imagen.class.php';
require_once __DIR__ . '/../src/entity/Categoria.php';
require_once __DIR__ . '/../src/repository/ImagenesRepository.php';
require_once __DIR__ . '/../src/repository/CategoriaRepository.php';

$errores = [];
$titulo = "";
$descripcion = "";
$mensaje = "";
$imagenes = [];
$categorias = [];

try {
    $config = require_once __DIR__ . '/../app/config.php';
    App::bind('config', $config); // Guardamos la configuración en el contenedor de servicios

    $imagenesRepository = new ImagenesRepository();
    $categoriaRepository = new CategoriaRepository();

    // Obtenemos las categorías y las imágenes existentes
    $categorias = $categoriaRepository->findAll();
    $imagenes = $imagenesRepository->findAll();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $titulo = trim(htmlspecialchars($_POST['titulo'] ?? ''));
        $descripcion = trim(htmlspecialchars($_POST['descripcion'] ?? ''));
        $categoria = trim(htmlspecialchars($_POST['categoria'] ?? ''));

        if (empty($categoria)) {
            throw new CategoriaException();
        }

        $tiposAceptados = ['image/jpeg', 'image/gif', 'image/png'];
        $imagen = new File('imagen', $tiposAceptados); // El nombre 'imagen' es el que se ha puesto en el formulario de galery.view.php
        $imagen->saveUploadFile(Imagen::RUTA_IMAGENES_SUBIDAS);

        $imagenGaleria = new Imagen($imagen->getFileName(), $descripcion, $categoria);
        $imagenesRepository->guarda($imagenGaleria);

        $mensaje = "Se ha guardado la imagen correctamente";
        $descripcion = "";
        $titulo = "";
        $imagenes = $imagenesRepository->findAll();
    }
} catch (FileException $fileException) {
    $errores[] = $fileException->getMessage();
} catch (CategoriaException $categoriaException) {
    $errores[] = "No se ha seleccionado una categoría válida";
} catch (QueryException $queryException) {
    $errores[] = $queryException->getMessage();
} catch (AppException $appException) {
    $errores[] = $appException->getMessage();
}

require_once __DIR__ . '/views/galery.view.php';
