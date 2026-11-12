<?php

namespace dwes\core\database;

use PDO;
use PDOException;
use dwes\app\entity\IEntity;
use dwes\app\exceptions\NotFoundException;
use dwes\app\exceptions\QueryException;
use dwes\core\App;

abstract class QueryBuilder
{
    /**
     * @var PDO
     */
    protected $connection;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var string
     */
    protected $classEntity;

    /**
     * Constructor que obtiene la conexión desde el contenedor App
     * e inicializa la tabla y entidad asociada
     *
     * @param string $table
     * @param string $classEntity
     */
    public function __construct(string $table, string $classEntity)
    {
        $this->connection = App::getConnection();
        $this->table = $table;
        $this->classEntity = $classEntity;
    }

    /**
     * Función que devuelve todos los registros de la tabla configurada
     * como un array de objetos de la clase classEntity.
     *
     * @return array
     * @throws QueryException
     */
    public function findAll(): array
    {
        $sql = "SELECT * FROM $this->table";

        return $this->executeQuery($sql);
    }

    /**
     * Busca y devuelve una entidad por su ID
     *
     * @param int $id
     * @return IEntity
     * @throws NotFoundException
     * @throws QueryException
     */
    public function find(int $id): IEntity
    {
        $sql = "SELECT * FROM $this->table WHERE id=$id";

        $result = $this->executeQuery($sql);

        if (empty($result)) {
            throw new NotFoundException("No se ha encontrado ningún elemento con id $id.");
        }

        return $result[0]; // La consulta devolverá un array con 1 solo elemento.
    }

    /**
     * Ejecuta una sentencia SQL y mapea el resultado a instancias de la entidad
     *
     * @param string $sql
     * @return array
     * @throws QueryException
     */
    private function executeQuery(string $sql): array
    {
        $pdoStatement = $this->connection->prepare($sql);
        if ($pdoStatement->execute() === false) {
            throw new QueryException("No se ha podido ejecutar la query solicitada.");
        }

        /*
         * PDO::FETCH_CLASS indica que queremos que devuelva los datos en un array de clases.
         * Los nombres de los campos de la BD deben coincidir con los nombres de los atributos de la clase.
         * PDO::FETCH_PROPS_LATE hace que se llame al constructor de la clase antes de que se asignen los valores.
         */
        return $pdoStatement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->classEntity);
    }

    /**
     * Inserta una entidad genérica en la base de datos
     *
     * @param IEntity $entity
     * @return void
     * @throws QueryException
     */
    public function save(IEntity $entity): void
    {
        try {
            $parameters = $entity->toArray();

            $sql = sprintf(
                'INSERT INTO %s (%s) VALUES (%s)',
                $this->table,
                implode(', ', array_keys($parameters)),
                ':' . implode(', :', array_keys($parameters))
            );
            $statement = $this->connection->prepare($sql);
            $statement->execute($parameters);
        } catch (PDOException $exception) {
            throw new QueryException("Error al insertar en la base de datos.");
        }
    }

    /**
     * Ejecuta una serie de operaciones en una transacción atómica
     *
     * @param callable $fnExecuteQuerys
     * @return void
     * @throws QueryException
     */
    public function executeTransaction(callable $fnExecuteQuerys)
    {
        try {
            $this->connection->beginTransaction();
            $fnExecuteQuerys(); // Llamamos a todas las consultas SQL de la transacción
            $this->connection->commit();
        } catch (PDOException $pdoException) {
            $this->connection->rollBack(); // Se deshacen todos los cambios desde beginTransaction()
            throw new QueryException("No se ha podido realizar la operación.");
        }
    }

    /**
     * Construye la cadena de asignación para la sentencia UPDATE
     *
     * @param array $parameters
     * @return string
     */
    public function getUpdates(array $parameters)
    {
        $updates = '';
        foreach ($parameters as $key => $value) {
            if ($key !== 'id') {
                if ($updates !== '') {
                    $updates .= ", ";
                }
                $updates .= $key . '=:' . $key;
            }
        }
        return $updates;
    }

    /**
     * Actualiza una entidad en la base de datos
     *
     * @param IEntity $entity
     * @return void
     * @throws QueryException
     */
    public function update(IEntity $entity): void
    {
        try {
            $parameters = $entity->toArray();

            $sql = sprintf(
                'UPDATE %s SET %s WHERE id=:id',
                $this->table,
                $this->getUpdates($parameters)
            );

            $statement = $this->connection->prepare($sql);
            $statement->execute($parameters);
        } catch (PDOException $pdoException) {
            throw new QueryException("No se ha podido actualizar el elemento con id " . $parameters['id']);
        }
    }
}
