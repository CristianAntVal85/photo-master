<?php

require_once __DIR__ . '/../../core/App.php';
require_once __DIR__ . '/../utils/exceptions/QueryException.php';
require_once __DIR__ . '/../entity/IEntity.php';

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
     * Selecciona todos los registros de la tabla configurada y
     * los devuelve mapeados en un array de instancias de classEntity
     *
     * @return array
     * @throws QueryException
     */
    public function findAll(): array
    {
        $sql = "SELECT * FROM {$this->table}";
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
}
