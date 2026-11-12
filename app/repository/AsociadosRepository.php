<?php

namespace dwes\app\repository;

use dwes\app\entity\Asociado;
use dwes\core\database\QueryBuilder;

class AsociadosRepository extends QueryBuilder
{
    /**
     * @param string $table
     * @param string $classEntity
     */
    public function __construct(string $table = 'asociados', string $classEntity = Asociado::class)
    {
        parent::__construct($table, $classEntity);
    }
}
