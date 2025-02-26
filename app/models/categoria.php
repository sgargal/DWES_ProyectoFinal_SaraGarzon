<?php

namespace Models;

require_once __DIR__ . '/../../config/Conexion.php';
use Config\Conexion;
use PDO;

class Categoria{
    public static function obtenerCategorias(){
        $conex = Conexion::Conectar();

        // Consulta para obtener todas las categorías
        $sql = "SELECT * FROM categorias";
        $stmt = $conex->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}