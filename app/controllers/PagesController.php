<?php

namespace dwes\app\controllers;

use dwes\app\entity\Asociado;
use dwes\app\entity\Imagen;
use dwes\app\exceptions\QueryException;
use dwes\app\repository\AsociadosRepository;
use dwes\app\repository\ImagenesRepository;
use dwes\app\utils\Utils;
use dwes\core\App;
use dwes\core\Response;

class PagesController
{
    /**
     * @throws QueryException
     */
    public function index()
    {
        $imagenesRepository = App::getRepository(ImagenesRepository::class);
        $asociadosRepository = App::getRepository(AsociadosRepository::class);

        $imagenesGaleria = $imagenesRepository->findAll();
        $asociadosLogos = $asociadosRepository->findAll();

        $imagenesHome = !empty($imagenesGaleria) ? $imagenesGaleria : [
            new Imagen("1.jpg", "imagen 1", "portfolio"),
            new Imagen("2.jpg", "imagen 2", "portfolio"),
            new Imagen("3.jpg", "imagen 3", "portfolio"),
            new Imagen("4.jpg", "imagen 4", "portfolio"),
            new Imagen("5.jpg", "imagen 5", "portfolio"),
            new Imagen("6.jpg", "imagen 6", "portfolio"),
            new Imagen("7.jpg", "imagen 7", "portfolio"),
            new Imagen("8.jpg", "imagen 8", "portfolio"),
            new Imagen("9.jpg", "imagen 9", "portfolio"),
            new Imagen("10.jpg", "imagen 10", "portfolio"),
            new Imagen("11.jpg", "imagen 11", "portfolio"),
            new Imagen("12.jpg", "imagen 12", "portfolio")
        ];

        $asociadosHome = !empty($asociadosLogos) ? $asociadosLogos : [
            new Asociado("First Partner Name", "log2.jpg", "Logo de First Partner Name"),
            new Asociado("Second Partner Name", "log1.jpg", "Logo de Second Partner Name"),
            new Asociado("Third Partner Name", "log3.jpg", "Logo de Third Partner Name")
        ];

        $asociadosHomeAleatorios = Utils::extraeElementosAleatorios($asociadosHome, min(3, count($asociadosHome)));

        Response::renderView(
            'index',
            'layout',
            compact('imagenesGaleria', 'asociadosLogos', 'imagenesHome', 'asociadosHomeAleatorios')
        );
    }

    public function about()
    {
        $imagenesClientes = [
            new Imagen("client1.jpg", "MISS BELLA", "Cliente"),
            new Imagen("client2.jpg", "DON PENO", "Cliente"),
            new Imagen("client3.jpg", "SWEETY", "Cliente"),
            new Imagen("client4.jpg", "LADY", "Cliente")
        ];

        Response::renderView('about', 'layout', compact('imagenesClientes'));
    }

    public function blog()
    {
        Response::renderView('blog', 'layout');
    }

    public function post()
    {
        Response::renderView('single_post', 'layout');
    }
}
