<?php

namespace App\Models;
use Config\Conexion;
use PDO;
use PDOException;

class Categoria{
    private $id;
    private $nombre;
    private Conexion $db;

    public function getId(){
        return $this->id;
    }

    public function getNombre() { 
        return $this->nombre; 
    }

    public function setId($id) { 
        $this->id = $id; 
    }

    public function setNombre($nombre) { 
        $this->nombre = $nombre; 
    }

    public function obtenerCategorias(){
        try{
            $this->db = new Conexion();

            // Consulta para obtener todas las categorías
            $sql = "SELECT * FROM categorias";
            $stmt = $this->db->Conectar()->prepare($sql);
            $stmt->execute();


            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $error){
            return "Error en la base de datos: " . $error->getMessage();
        }
        
    }

    public function crearCategoria($nombre){
        try{
            $this->db = new Conexion();
            $sql = "INSERT INTO categorias (nombre) VALUES (:nombre)";
            $stmt = $this->db->Conectar()->prepare($sql);
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);

            $resultado = $stmt->execute();

            $this->db->cerrarBD();
            
            return $resultado;

        }catch(PDOException $error){
            die("Error al insertar una categoría: " . $error->getMessage());
        }
    }

}