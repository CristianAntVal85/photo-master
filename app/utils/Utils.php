<?php

namespace dwes\app\utils;

class Utils {

    public static function extraeElementosAleatorios(array $lista, int $cantidad): ?array
    {
        if ($cantidad < 1 || count($lista) === 0) {
            return null;
        }

        shuffle($lista);
        return array_slice($lista, 0, $cantidad);
    }

    public static function esOpcionMenuActiva(string $opcion): bool
    {
        $rutaActual = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $rutaActual = '/' . trim(is_string($rutaActual) ? $rutaActual : '', '/');
        $opcion = '/' . trim($opcion, '/');

        return $rutaActual === $opcion;
    }

    public static function existeOpcionMenuActivaEnArray(array $opciones): bool
    {
        foreach ($opciones as $opcionMenu) {
            if (self::esOpcionMenuActiva($opcionMenu)) {
                return true;
            }
        }

        return false;
    }
}
?>