<?php

require_once __DIR__ . '/../../src/utils/exceptions/QueryException.php';
require_once __DIR__ . '/../../src/exceptions/AppException.class.php';
require_once __DIR__ . '/../../src/repository/ImagenesRepository.php';
require_once __DIR__ . '/../../src/repository/CategoriaRepository.php';

$errores = $errores ?? [];
$titulo = $titulo ?? '';
$descripcion = $descripcion ?? '';
$mensaje = $mensaje ?? '';
$imagenes = [];
$categorias = [];

try {
    App::getConnection();
    $imagenesRepository = new ImagenesRepository();
    $categoriaRepository = new CategoriaRepository();

    $categorias = $categoriaRepository->findAll();
    $imagenes = $imagenesRepository->findAll();
} catch (QueryException $queryException) {
    $errores[] = $queryException->getMessage();
} catch (AppException $appException) {
    $errores[] = $appException->getMessage();
}

require_once __DIR__ . '/../views/galery.view.php';
