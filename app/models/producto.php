<?php
namespace App\Models;
use Config\Conexion;
use PDO;
use PDOException;

class Producto{
    private Conexion $db;

    public function obtenerProductos(){
        try{
            $this->db = new Conexion();
            $sql = "SELECT p.*, c.nombre AS categoria FROM productos p 
                      JOIN categorias c ON p.categoria_id = c.id";
            $stmt = $this->db->Conectar()->query($sql);
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($productos)) {
                return [];
            }
    
            return $productos;
        }catch(PDOException $error){
            return [];
        }
    }

    public function crearProducto($nombre, $descripcion, $precio, $stock, $categoria_id, $imagen){
        
        
        try{
            $this->db = new Conexion();
            $sql = "INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id, imagen) 
                      VALUES (:nombre, :descripcion, :precio, :stock, :categoria_id, :imagen)";
            $stmt = $this->db->Conectar()->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':stock', $stock);
            $stmt->bindParam(':categoria_id', $categoria_id);
            $stmt->bindParam(':imagen', $imagen);
            return $stmt->execute();
        }catch(PDOException $error){
            return false;
        }
    }

}
?>