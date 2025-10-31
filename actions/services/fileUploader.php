<?php
class fileUploader {
    private $relativeDir; // Direccion relativa obtenida del constructor
    private $uploadDir; // Direccion absoluta construida

    public function __construct($dir){
        $this->relativeDir = $dir;  // assets/userPhotos
        $projectRoot = dirname(__DIR__, 2); // Ir dos carpetas hacia arriba
        $this->uploadDir = $projectRoot . '/' . $this->relativeDir . '/'; 
        // C:/xampp/htdocs/Proyecto-1/assets/userPhotos/
    }

    public function upload($file) {
        // Verificar que la imagen no se encuentre corrupta
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Error al subir la imagen");
        }

        // Verificar que el archivo sea de un formato compatible
        $fileType = mime_content_type($file['tmp_name']);
        if ($fileType !== 'image/jpeg' && $fileType !== 'image/png') {
            throw new Exception("Solo se permiten imagenes JPG o PNG");
        }

        // Crear carpeta si no existe
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }

        // Darle un nombre unico
        $fileName = uniqid() . '_' . basename($file['name']);
        $targetPath = $this->uploadDir . $fileName;

        // Pasar de la ruta temporal a la ruta final
        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            throw new Exception("Error al mover el archivo al destino");
        }

        // Retorna ruta relativa para guardar en BD
        return '../' . $this->relativeDir . '/' . $fileName; // assets/userPhotos/nombre_unico.jpg
    }
}
