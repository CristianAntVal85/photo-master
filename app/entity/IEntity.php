<?php

namespace dwes\app\entity;

interface IEntity
{
    /**
     * Convierte la entidad en un array asociativo clave => valor
     * para operaciones de base de datos
     *
     * @return array
     */
    public function toArray(): array;
}
