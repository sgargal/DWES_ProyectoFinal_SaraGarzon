<?php
namespace App\Models;
use Config\Conexion;
use PDO;
use PDOException;

class Producto{
    private $id;
    private $categoria_id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $stock;
    private $oferta;
    private $fecha;
    private $imagen;
    private Conexion $db;

    // Getter y Setter para $id
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    // Getter y Setter para $categoria_id
    public function getCategoriaId() {
        return $this->categoria_id;
    }

    public function setCategoriaId($categoria_id) {
        $this->categoria_id = $categoria_id;
    }

    // Getter y Setter para $nombre
    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    // Getter y Setter para $descripcion
    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    // Getter y Setter para $precio
    public function getPrecio() {
        return $this->precio;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    // Getter y Setter para $stock
    public function getStock() {
        return $this->stock;
    }

    public function setStock($stock) {
        $this->stock = $stock;
    }

    // Getter y Setter para $oferta
    public function getOferta() {
        return $this->oferta;
    }

    public function setOferta($oferta) {
        $this->oferta = $oferta;
    }

    // Getter y Setter para $fecha
    public function getFecha() {
        return $this->fecha;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    // Getter y Setter para $imagen
    public function getImagen() {
        return $this->imagen;
    }

    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }

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