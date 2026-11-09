<?php 
require_once __DIR__ . '/../src/utils/File.class.php';
require_once __DIR__ . '/../src/utils/exceptions/FileException.class.php';
require_once __DIR__ . '/../src/utils/exceptions/QueryException.php';
require_once __DIR__ . '/../src/utils/entity/Imagen.class.php';
require_once __DIR__ . '/../src/database/Connection.class.php';
require_once __DIR__ . '/../src/database/QueryBuilder.php';

$errores = []; 
$titulo = '';
$descripcion = ''; 
$mensaje = ''; 
$imagenes = [];

try { 
    $conexion = Connection::make(); 

    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    { 
        $titulo = trim(htmlspecialchars($_POST['titulo'] ?? ''));
        $descripcion = trim(htmlspecialchars($_POST['descripcion'] ?? '')); 
        $tiposAceptados = ['image/jpeg','image/gif','image/png']; 
        $imagen = new File('imagen', $tiposAceptados); // El nombre 'imagen' es el que se ha puesto en el formulario de galery.view.php 
        $imagen->saveUploadFile(Imagen::RUTA_IMAGENES_SUBIDAS); 

        // Inserción de la nueva imagen en la base de datos
        $sql = "INSERT INTO imagenes (nombre, descripcion, categoria) VALUES (:nombre,:descripcion,:categoria)"; 
        $pdoStatement = $conexion->prepare($sql); 
        $parametros = [
            ':nombre' => $imagen->getFileName(), 
            ':descripcion' => $descripcion, 
            ':categoria' => '1'
        ]; 

        if ($pdoStatement->execute($parametros) === false) {
            $errores[] = "No se ha podido guardar la imagen en la base de datos"; 
        } else {
            $descripcion = ""; 
            $mensaje = "Se ha guardado la imagen correctamente"; 
        }
    } 

    // Recuperamos todas las imágenes registradas en la base de datos mapeadas a objetos Imagen
    $queryBuilder = new QueryBuilder($conexion); 
    $imagenes = $queryBuilder->findAll('imagenes', 'Imagen'); 
} 
catch (FileException $fileException) { 
    $errores[] = $fileException->getMessage(); 
} 
catch (QueryException $queryException) { 
    $errores[] = $queryException->getMessage(); 
} 

require_once __DIR__ . '/views/galery.view.php';