<?php

require_once __DIR__ . '/../database/QueryBuilder.php';
require_once __DIR__ . '/../entity/Categoria.php';

class CategoriaRepository extends QueryBuilder
{
    /**
     * @param string $table
     * @param string $classEntity
     */
    public function __construct(string $table = 'categorias', string $classEntity = 'Categoria')
    {
        parent::__construct($table, $classEntity);
    }
}
