<?php

namespace dwes\app\repository;

use dwes\app\entity\Categoria;
use dwes\app\entity\Imagen;
use dwes\app\exceptions\NotFoundException;
use dwes\app\exceptions\QueryException;
use dwes\core\App;
use dwes\core\database\QueryBuilder;

class ImagenesRepository extends QueryBuilder
{
    /**
     * @param string $table
     * @param string $classEntity
     */
    public function __construct(string $table = 'imagenes', string $classEntity = Imagen::class)
    {
        parent::__construct($table, $classEntity);
    }

    /**
     * Obtiene la categoría correspondiente a una imagen
     *
     * @param Imagen $imagenGaleria
     * @return Categoria
     * @throws NotFoundException
     * @throws QueryException
     */
    public function getCategoria(Imagen $imagenGaleria): Categoria
    {
        $categoriaRepository = App::getRepository(CategoriaRepository::class);
        return $categoriaRepository->find((int)$imagenGaleria->getCategoria());
    }

    /**
     * Guarda la imagen e incrementa el contador de la categoría
     * dentro de una transacción atómica
     *
     * @param Imagen $imagenGaleria
     * @return void
     * @throws QueryException
     */
    public function guarda(Imagen $imagenGaleria)
    {
        $fnGuardaImagen = function () use ($imagenGaleria) { // Creamos una función anónima que se llama como callable
            $categoria = $this->getCategoria($imagenGaleria);
            $categoriaRepository = App::getRepository(CategoriasRepository::class);
            $categoriaRepository->nuevaImagen($categoria);
            $this->save($imagenGaleria);
        };
        $this->executeTransaction($fnGuardaImagen); // Se pasa un callable
    }
}
