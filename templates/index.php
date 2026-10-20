<?php 
require_once __DIR__ . '/../src/utils/entity/imagen.class.php';

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

require_once __DIR__ . '/views/index.view.php';