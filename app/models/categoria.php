<?php

namespace Models;

require_once __DIR__ . '/../../config/Conexion.php';
use Config\Conexion;
use PDO;
use PDOException;

class Categoria{

    public static function obtenerCategorias(){
        $conex = Conexion::Conectar();

        // Consulta para obtener todas las categorías
        $sql = "SELECT * FROM categorias";
        $stmt = $conex->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearCategoria($nombre){
        try{
            $conex = Conexion::Conectar();
            $sql = "INSERT INTO categorias (nombre) VALUES (:nombre)";
            $stmt = $conex->prepare($sql);
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            return $stmt->execute();

        }catch(PDOException $error){
            die("Error al insertar una categoría: " . $error->getMessage());
        }
    }

}