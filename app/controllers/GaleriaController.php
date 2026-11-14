<?php

namespace dwes\app\controllers;

use dwes\app\exceptions\AppException;
use dwes\app\exceptions\QueryException;
use dwes\app\repository\CategoriaRepository;
use dwes\app\repository\ImagenesRepository;
use dwes\app\entity\Imagen;
use dwes\app\exceptions\CategoriaException;
use dwes\app\exceptions\FileException;
use dwes\app\exceptions\NotFoundException;
use dwes\app\utils\File;
use dwes\core\App;
use dwes\core\Response;

class GaleriaController
{
    /**
     * Muestra la galería con el formulario y el listado de imágenes
     *
     * @return void
     */
    public function index()
    {
        $errores = [];
        $titulo = '';
        $descripcion = '';
        $mensaje = '';
        $imagenes = [];
        $categorias = [];

        try {
            App::getConnection();
            $imagenesRepository = App::getRepository(ImagenesRepository::class);
            $categoriaRepository = App::getRepository(CategoriaRepository::class);

            $categorias = $categoriaRepository->findAll();
            $imagenes = $imagenesRepository->findAll();
        } catch (QueryException $queryException) {
            $errores[] = $queryException->getMessage();
        } catch (AppException $appException) {
            $errores[] = $appException->getMessage();
        }

        Response::renderView(
            'galery',
            'layout',
            compact('errores', 'titulo', 'descripcion', 'mensaje', 'imagenes', 'categorias', 'imagenesRepository')
        );
    }

    /**
     * Procesa la subida y registro de una nueva imagen
     *
     * @return void
     */
    public function nueva()
    {
        $errores = [];
        $titulo = trim(htmlspecialchars($_POST['titulo'] ?? ''));
        $descripcion = trim(htmlspecialchars($_POST['descripcion'] ?? ''));
        $mensaje = '';
        $imagenes = [];
        $categorias = [];
        $imagenesRepository = App::getRepository(ImagenesRepository::class);
        $categoriaRepository = App::getRepository(CategoriaRepository::class);

        try {
            App::getConnection();
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
            return;
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

        try {
            $categorias = $categoriaRepository->findAll();
            $imagenes = $imagenesRepository->findAll();
        } catch (\Exception $e) {
            // Ignorar para renderizar con los errores actuales
        }

        Response::renderView(
            'galery',
            'layout',
            compact('errores', 'titulo', 'descripcion', 'mensaje', 'imagenes', 'categorias', 'imagenesRepository')
        );
    }
}
