<?php

class Asociado {

    /**
     * @var int
    */
    private $id = null;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $logo;

    /**
     * @var string
     */
    private $descripcion;

    public const RUTA_LOGOS_ASOCIADOS = '/public/images/asociados';

    public function __construct(
        $nombre = "",
        $logo = "",
        $descripcion = ""
    ) {
        $this->id = null;
        $this->nombre = $nombre;
        $this->logo = $logo;
        $this->descripcion = $descripcion;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getLogo()
    {
        return $this->logo;
    }

    public function setLogo($logo)
    {
        $this->logo = $logo;
        return $this;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    public function getRutaLogosAsociados()
    {
        return self::RUTA_LOGOS_ASOCIADOS;
    }

    public function getUrl()
    {
        return rtrim(self::RUTA_LOGOS_ASOCIADOS, '/') . '/' . ltrim($this->logo, '/');
    }

    public function __toString(): string
    {
        return $this->descripcion;
    }
}
