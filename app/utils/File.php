<?php

namespace dwes\app\utils;

use finfo;
use dwes\app\exceptions\FileException;
 
class File 
{ 
    private $file;  // Contenido del fichero que se sube al servidor 
    private $fileName; // Nombre del fichero 
    private $fileType;
 
    // Se pasa el nombre del fichero y una lista con los tipos de archivos que acepta la clase. 

    /** 
    * param string $fileName 
    * param array $arrTypes 
    * @throws FileException 
    */ 
    public function __construct (string $fileName, array $arrTypes) 
    { 
        if (!isset($_FILES[$fileName]) || !is_array($_FILES[$fileName])) {
            throw new FileException('Debes seleccionar un fichero');
        }

        $this->file = $_FILES[$fileName]; // $_FILES guarda los datos que se envían en forma de fichero 
        $this->fileName=''; 
 
        if ( $this->file['error'] !== UPLOAD_ERR_OK ) // Si se ha producido algún error en la subida 
        { 
            switch ($this->file['error']) 
            { 
                case UPLOAD_ERR_NO_FILE:
                    throw new FileException('Debes seleccionar un fichero');

                case UPLOAD_ERR_INI_SIZE: 
                case UPLOAD_ERR_FORM_SIZE: 

                    throw new FileException('El fichero es demasiado grande');

                case UPLOAD_ERR_PARTIAL: 

                    throw new FileException('No se ha podido subir el fichero completo'); 

                default: 

                    throw new FileException('No se ha podido subir el fichero');

                    break; 
            } 
        } 
 
        if (!is_uploaded_file($this->file['tmp_name'])) {
            throw new FileException('El archivo no ha sido subido mediante un formulario.');
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $this->fileType = $finfo->file($this->file['tmp_name']);

        // Comprobar el tipo real del fichero, no el MIME enviado por el navegador.
        if ($this->fileType === false || in_array($this->fileType, $arrTypes, true) === false)
            throw new FileException('Tipo de fichero no soportado');
        
    } 

    /**
     * @param string $rutaDestino
     * @return void
     * @throws FileException
     */
    public function saveUploadFile(string $rutaDestino)
    {
        if (is_uploaded_file($this->file['tmp_name']) === false) {
            throw new FileException('El archivo no ha sido subido mediante un formulario.');
        }

        $extensionesPorTipo = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
        ];
        if (!isset($extensionesPorTipo[$this->fileType])) {
            throw new FileException('Tipo de fichero no soportado');
        }

        $documentRoot = $_SERVER['DOCUMENT_ROOT'] ?? '';
        if ($documentRoot === '') {
            throw new FileException('No se ha podido determinar la ruta de destino');
        }

        $rutaDirectorio = rtrim($documentRoot, '/') . '/' . trim($rutaDestino, '/') . '/';
        if (!is_dir($rutaDirectorio) && !mkdir($rutaDirectorio, 0755, true) && !is_dir($rutaDirectorio)) {
            throw new FileException('No se ha podido crear el directorio de destino');
        }

        $nombreBase = pathinfo(basename(str_replace('\\', '/', $this->file['name'])), PATHINFO_FILENAME);
        $nombreBase = trim((string) preg_replace('/[^a-zA-Z0-9_-]+/', '_', $nombreBase), '_-');
        if ($nombreBase === '') {
            $nombreBase = 'logo';
        }

        $extension = $extensionesPorTipo[$this->fileType];
        $this->fileName = $nombreBase . '.' . $extension;
        $ruta = $rutaDirectorio . $this->fileName;

        // Comprobamos si ya existe el fichero.
        if (is_file($ruta) === true) {
            $this->fileName = $nombreBase . '_' . bin2hex(random_bytes(6)) . '.' . $extension;
            $ruta = $rutaDirectorio . $this->fileName;
        }

        if (is_file($ruta)) {
            throw new FileException('No se ha podido generar un nombre de fichero único');
        }

        if (move_uploaded_file($this->file['tmp_name'], $ruta) === false) {
            throw new FileException('No se puede mover el archivo a su destino');
        }
    }
 
    public function getFileName() 
    { 
        return $this->fileName; 
    } 
}