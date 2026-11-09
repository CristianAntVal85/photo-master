<?php

class Connection
{
    public static function make()
    {
        try {
            $opciones = [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", // Para utilizar utf8
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,      // Para poder capturar la excepción
                PDO::ATTR_PERSISTENT => true                      // Guarda la conexión y no hay que volver a abrirla en la siguiente petición
            ];

            $connection = new PDO(
                'mysql:host=localhost;dbname=cursophp;charset=utf8',
                'usercurso',
                'php',
                $opciones
            );
        } catch (PDOException $PDOException) {
            die($PDOException->getMessage()); // Se muestra la excepción como si fuera un echo y detiene la ejecución del script
        }

        return $connection;
    }
}
