<?php

require_once __DIR__ . '/../database/QueryBuilder.php';
require_once __DIR__ . '/../utils/entity/Imagen.class.php';
require_once __DIR__ . '/CategoriaRepository.php';
require_once __DIR__ . '/../entity/Categoria.php';
require_once __DIR__ . '/../exceptions/NotFoundException.php';

class ImagenesRepository extends QueryBuilder
{
    /**
     * @param string $table
     * @param string $classEntity
     */
    public function __construct(string $table = 'imagenes', string $classEntity = 'Imagen')
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
        $categoriaRepository = new CategoriaRepository();
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
            $categoriaRepository = new CategoriasRepository();
            $categoriaRepository->nuevaImagen($categoria);
            $this->save($imagenGaleria);
        };
        $this->executeTransaction($fnGuardaImagen); // Se pasa un callable
    }
}
