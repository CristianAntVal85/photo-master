<?php

class Imagen {

    /**
     * @var int
    */
    private $id;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var string
     */
    private $categoria;

    /**
     * @var int
     */
    private $numVisualizaciones;

    /**
     * @var int
     */
    private $numLikes;

    /**
     * @var int
     */
    private $numDownloads;

    public function __construct(
        $nombre,
        $descripcion,
        $categoria,
        $numVisualizaciones = 0,
        $numLikes = 0,
        $numDownloads = 0
    ) {
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->categoria = $categoria;
        $this->numVisualizaciones = $numVisualizaciones;
        $this->numLikes = $numLikes;
        $this->numDownloads = $numDownloads;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     * @return Imagen
     */
    public function setNombre(string $nombre): Imagen
    {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    /**
     * @param string $descripcion
     * @return Imagen
     */
    public function setDescripcion(string $descripcion): Imagen
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    /**
     * @return string
     */
    public function getCategoria(): string
    {
        return $this->categoria;
    }

    /**
     * @param string $categoria
     * @return Imagen
     */
    public function setCategoria(string $categoria): Imagen
    {
        $this->categoria = $categoria;
        return $this;
    }

    /**
     * @return int
     */
    public function getNumVisualizaciones(): int
    {
        return $this->numVisualizaciones;
    }

    /**
     * @param int $numVisualizaciones
     * @return Imagen
     */
    public function setNumVisualizaciones(int $numVisualizaciones): Imagen
    {
        $this->numVisualizaciones = $numVisualizaciones;
        return $this;
    }

    /**
     * @return int
     */
    public function getNumLikes(): int
    {
        return $this->numLikes;
    }

    /**
     * @param int $numLikes
     * @return Imagen
     */
    public function setNumLikes(int $numLikes): Imagen
    {
        $this->numLikes = $numLikes;
        return $this;
    }

    /**
     * @return int
     */
    public function getNumDownloads(): int
    {
        return $this->numDownloads;
    }

    /**
     * @param int $numDownloads
     * @return Imagen
     */
    public function setNumDownloads(int $numDownloads): Imagen
    {
        $this->numDownloads = $numDownloads;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->descripcion;
    }

    /**
     * Rutas de las imágenes
     */
    const RUTA_IMAGENES_PORTFOLIO = '/public/images/index/portfolio/'; 
    const RUTA_IMAGENES_GALERIA = '/public/images/index/gallery/'; 
    const RUTA_IMAGENES_CLIENTES = '/public/images/clients/'; 
    const RUTA_IMAGENES_SUBIDAS = '/public/images/index/gallery/subidas/';

    /**
     * @return string
     */
    public function getUrlPortfolio(): string
    {
        return self::RUTA_IMAGENES_PORTFOLIO . $this->getNombre();
    }

    /**
     * @return string
     */
    public function getUrlGaleria(): string
    {
        return self::RUTA_IMAGENES_GALERIA . $this->getNombre();
    }

    /**
     * @return string
     */
    public function getUrlClientes(): string
    {
        return self::RUTA_IMAGENES_CLIENTES . $this->getNombre();
    }
}
