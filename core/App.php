<?php

require_once __DIR__ . '/../src/exceptions/AppException.class.php';
require_once __DIR__ . '/../src/database/Connection.php';

class App
{
    /**
     * Contenedor de servicios / dependencias
     *
     * @var array
     */
    private static $container = [];

    /**
     * Guarda un servicio en el contenedor
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function bind(string $key, $value)
    {
        static::$container[$key] = $value;
    }

    /**
     * Obtiene un servicio del contenedor
     *
     * @param string $key
     * @return mixed
     * @throws AppException
     */
    public static function get(string $key)
    {
        if (!array_key_exists($key, static::$container)) {
            throw new AppException("No se ha encontrado la clave $key en el contenedor");
        }

        return static::$container[$key];
    }

    /**
     * Obtiene la conexión a la base de datos (creándola sólo si no existe aún)
     *
     * @return PDO
     * @throws AppException
     */
    public static function getConnection()
    {
        if (!array_key_exists('connection', static::$container)) {
            static::$container['connection'] = Connection::make();
        }

        return static::$container['connection'];
    }
}
