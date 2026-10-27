<?php
require_once __DIR__ . '/views/about.view.php';
require_once __DIR__ . '/../src/utils/entity/Imagen.class.php';

/**
 * @var Imagen[]
 */
$imagenesClientes = [
    new Imagen(
        "client1.jpg",
        "MISS BELLA",
        "Cliente"
    ),
    new Imagen(
        "client2.jpg",
        "DON PENO",
        "Cliente"
    ),
    new Imagen(
        "client3.jpg",
        "SWEETY",
        "Cliente"
    ),
    new Imagen(
        "client4.jpg",
        "LADY",
        "Cliente"
    ),
]
?>