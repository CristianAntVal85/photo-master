<?php

namespace dwes\core\database;

use PDO;
use PDOException;
use dwes\app\exceptions\AppException;
use dwes\core\App;

class Connection
{
    /**
     * Crea y devuelve la conexión PDO obteniendo la configuración
     * desde el contenedor de servicios (App)
     *
     * @return PDO
     * @throws AppException
     */
    public static function make()
    {
        try {
            $config = App::get('config')['database'];
            $connection = new PDO(
                $config['connection'] . ';dbname=' . $config['name'],
                $config['username'],
                $config['password'],
                $config['options']
            );
        } catch (PDOException $PDOException) {
            throw new AppException('No se ha podido crear la conexión a la base de datos');
        }

        return $connection;
    }
}
