<?php

namespace dwes\core;

class Response
{
    /**
     * Renderiza una vista dentro de un layout especificado
     *
     * @param string $name Nombre de la vista (sin .view.php)
     * @param string $layout Nombre del layout (sin .view.php)
     * @param array $data Variables que se pasan a la vista
     * @return void
     */
    public static function renderView(string $name, string $layout = 'layout', array $data = [])
    {
        // Creamos variables con el contenido del array
        extract($data); // El nombre de las variables serán las claves del array
        ob_start(); // Las salidas se guardan en un buffer intermedio.
        require __DIR__ . "/../app/views/$name.view.php"; // Obtenemos el archivo de la vista
        $mainContent = ob_get_clean(); // Recuperamos el contenido del buffer
        require __DIR__ . "/../app/views/$layout.view.php";
    }
}
