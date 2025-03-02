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

    public function __construct() {
        $this->db = new Conexion();
    }

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

    public function obtenerProductoPorId($id){
        try {
            // Preparamos la consulta SQL para obtener un producto por su ID
            $query = "SELECT * FROM productos WHERE id = :id LIMIT 1";
            
            // Preparamos la declaración
            $stmt = $this->db->Conectar()->prepare($query);
            
            // Vinculamos el parámetro :id a la variable $id
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            // Ejecutamos la consulta
            $stmt->execute();
            
            // Recuperamos el resultado
            $producto = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificamos si se encontró el producto
            if ($producto) {
                return $producto;
            } else {
                // Si no se encuentra, podrías devolver null o lanzar una excepción
                return null;
            }
        } catch (PDOException $e) {
            // Manejo de errores
            die("Error al obtener el producto: " . $e->getMessage());
        }
    }
    
    public function obtenerProductosPorCategoria($categoria_id){
        $sql = "SELECT * FROM productos WHERE categoria_id = ?";
        $stmt = $this->db->Conectar()->prepare($sql);
        $stmt->execute([$categoria_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function editar($id, $nombre, $descripcion, $precio, $stock, $categoria_id, $imagen){
        try{
            $sql = "UPDATE productos SET
                    nombre = :nombre,
                    descripcion = :descripcion,
                    precio = :precio,
                    stock = :stock,
                    categoria_id = :categoria_id,
                    imagen = :imagen
                    WHERE id = :id";
            $stmt = $this->db->Conectar()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':stock', $stock);
            $stmt->bindParam(':categoria_id', $categoria_id);
            $stmt->bindParam(':imagen', $imagen);

            return $stmt->execute();
        }catch(PDOException $error){
            die("Error en la base de datos: " . $error->getMessage());
        }
    }

}   
?>