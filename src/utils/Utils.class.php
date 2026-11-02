<?php

class Utils {

    public static function extraeElementosAleatorios(array $lista, int $cantidad): ?array
    {
        if ($cantidad < 1 || count($lista) === 0) {
            return null;
        }

        shuffle($lista);
        return array_slice($lista, 0, $cantidad);
    }

    public static function esOpcionMenuActiva($opcion): bool 
    { 
        $actual = explode('/',$_SERVER['REQUEST_URI']); 
        $actual = '/'.$actual[count($actual)-1];

        if ( $actual === $opcion) { 
            return true; 
        } 
        else { 
            return false; 
        } 
    
    } 
}
?>