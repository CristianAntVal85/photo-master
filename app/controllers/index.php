<?php 
require_once __DIR__ . '/../../src/utils/entity/Imagen.class.php';
require_once __DIR__ . '/../../src/utils/entity/asociado.class.php';
require_once __DIR__ . '/../../src/utils/Utils.class.php';

$imagenesHome = [
    new Imagen(
        "1.jpg",
        "imagen 1",
        "portfolio"
    ),
    new Imagen(
        "2.jpg",
        "imagen 2",
        "portfolio"
    ),
    new Imagen(
        "3.jpg",
        "imagen 3",
        "portfolio"
    ),
    new Imagen(
        "4.jpg",
        "imagen 4",
        "portfolio"
    ),
    new Imagen(
        "5.jpg",
        "imagen 5",
        "portfolio"
    ),
    new Imagen(
        "6.jpg",
        "imagen 6",
        "portfolio"
    ),
    new Imagen(
        "7.jpg",
        "imagen 7",
        "portfolio"
    ),
    new Imagen(
        "8.jpg",
        "imagen 8",
        "portfolio"
    ),
    new Imagen(
        "9.jpg",
        "imagen 9",
        "portfolio"
    ),
    new Imagen(
        "10.jpg",
        "imagen 10",
        "portfolio"
    ),
    new Imagen(
        "11.jpg",
        "imagen 11",
        "portfolio"
    ),
    new Imagen(
        "12.jpg",
        "imagen 12",
        "portfolio"
    )
];

$asociadosHome = [
    new Asociado(
        "First Partner Name",
        "log2.jpg",
        "Logo de First Partner Name"
    ),
    new Asociado(
        "Second Partner Name",
        "log1.jpg",
        "Logo de Second Partner Name"
    ),
    new Asociado(
        "Third Partner Name",
        "log3.jpg",
        "Logo de Third Partner Name"
    )
];

$asociadosHomeAleatorios = Utils::extraeElementosAleatorios($asociadosHome, 3);
if ($asociadosHomeAleatorios === null) {
    throw new RuntimeException('No se pudieron seleccionar los asociados del Home.');
}

require_once __DIR__ . '/../views/index.view.php';