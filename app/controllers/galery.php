<?php

use dwes\app\exceptions\AppException;
use dwes\app\exceptions\QueryException;
use dwes\app\repository\CategoriaRepository;
use dwes\app\repository\ImagenesRepository;
use dwes\core\App;

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
