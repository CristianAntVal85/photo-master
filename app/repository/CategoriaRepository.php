<?php

namespace dwes\app\repository;

use dwes\app\entity\Categoria;
use dwes\app\exceptions\QueryException;
use dwes\core\database\QueryBuilder;

class CategoriaRepository extends QueryBuilder
{
    /**
     * @param string $table
     * @param string $classEntity
     */
    public function __construct(string $table = 'categorias', string $classEntity = Categoria::class)
    {
        parent::__construct($table, $classEntity);
    }

    /**
     * Incrementa el número de imágenes de una categoría y actualiza la BBDD
     *
     * @param Categoria $categoria
     * @return void
     * @throws QueryException
     */
    public function nuevaImagen(Categoria $categoria)
    {
        $categoria->setNumImagenes($categoria->getNumImagenes() + 1);
        $this->update($categoria);
    }
}
