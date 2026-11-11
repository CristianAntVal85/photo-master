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

// Alias para permitir tanto CategoriaRepository como CategoriasRepository
class CategoriasRepository extends CategoriaRepository
{
}
