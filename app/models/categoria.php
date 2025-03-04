<?php

namespace App\Models;
<<<<<<< HEAD
=======

require_once __DIR__ . '/../../config/Conexion.php';
>>>>>>> c44ce45be6473bc1bae740aff3d0b801a5fa3dc9
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
<<<<<<< HEAD
            $stmt = $this->db->Conectar()->prepare($sql);
            $stmt->execute();


            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $error){
            return "Error en la base de datos: " . $error->getMessage();
=======
            $stmt = $this->db->Conectar()->query($sql);
            $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);


            if (empty($categorias)) {
                return [];
            }

            return $categorias;
        }catch(PDOException $error){
            echo "Error en la base de datos: " . $error->getMessage();
            return [];
>>>>>>> c44ce45be6473bc1bae740aff3d0b801a5fa3dc9
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