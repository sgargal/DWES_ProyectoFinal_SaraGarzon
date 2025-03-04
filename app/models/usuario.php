<?php
namespace App\Models;
use Config\Conexion;

use PDO;
use PDOException;
use Exception;

class Usuario {
    private $id;
    private $nombre;
    private $apellidos;
    private $email;
    private $password;
    private $rol;
    private Conexion $db;


    // Getters and setters
    public function getId() { 
        return $this->id; 
    }
    public function getNombre() { 
        return $this->nombre; 
    }
    public function getApellidos() { 
        return $this->apellidos; 
    }
    public function getEmail() {
        return $this->email; 
    }
    public function getPassword() { 
        return $this->password; 
    }
    public function getRol() { 
        return $this->rol; 
    }

    public function setId($id) { $this->id = $id; }
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setApellidos($apellidos) { $this->apellidos = $apellidos; }
    public function setEmail($email) { $this->email = $email; }
    public function setPassword($password) { $this->password = $password; }
    public function setRol($rol) { $this->rol = $rol; }

    // Método para registrar un usuario
    public function registro() {
        try {
            $this->db = new Conexion();
            $sql = "INSERT INTO usuarios (nombre, apellidos, email, password, rol) 
                    VALUES (:nombre, :apellidos, :email, :password, :rol)";
            $stmt = $this->db->Conectar()->prepare($sql);
            $passwordHash = password_hash($this->password, PASSWORD_BCRYPT);
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':apellidos', $this->apellidos);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $passwordHash);
            $stmt->bindParam(':rol', $this->rol);

            $resultado = $stmt->execute();

            $this->db->cerrarBD();
            if ($resultado) {
                return "Usuario registrado correctamente";
            } else {
                return "Error al registrar el usuario";
            }
            
        } catch (PDOException $error) {
            return "Error en la base de datos: " . $error->getMessage();
        }
    }

    public function login($email, $password){
        try{
            $this->db = new Conexion(); // Establecer conexión con la base de datos

            $sql = "SELECT * FROM usuarios WHERE email = :email";
            $stmt = $this->db->Conectar()->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->db->cerrarBD(); 

            if (!$usuario || !password_verify($password, $usuario['password'])) {
                return false; // Usuario no encontrado o contraseña incorrecta
            }

            return $usuario;
        } catch (PDOException $error) {
            throw new Exception("Error en la base de datos: " . $error->getMessage());
        }
    }

    // Método para editar un usuario
    public function editarUsuario($id, $nombre, $apellidos, $email, $password, $rol) {
        try {
            $this->db = new Conexion();

            if (!empty($password)) {
                $passwordHash = password_hash($password, PASSWORD_BCRYPT);
                $sql = "UPDATE usuarios 
                        SET nombre = :nombre, apellidos = :apellidos, email = :email, password = :password, rol = :rol 
                        WHERE id = :id";
            } else {
                $sql = "UPDATE usuarios 
                        SET nombre = :nombre, apellidos = :apellidos, email = :email, rol = :rol 
                        WHERE id = :id";
            }

            $stmt = $this->db->Conectar()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellidos', $apellidos);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':rol', $rol);

            if (!empty($password)) {
                $stmt->bindParam(':password', $passwordHash);
            }

            $resultado = $stmt->execute(); 

            $this->db->cerrarBD();

            return $resultado;  // Devuelve true si se actualizó correctamente

        } catch (PDOException $error) {
            throw new Exception("Error en la base de datos: " . $error->getMessage());
        }
    }

    // Método para cambiar la contraseña de un usuario
    public function cambiarPassword($id, $nueva_password) {
        try {
            $this->db = new Conexion();

            // Encriptar la nueva contraseña
            $passwordHash = password_hash($nueva_password, PASSWORD_BCRYPT);

            // Actualizar la contraseña del usuario
            $sql = "UPDATE usuarios 
                    SET password = :password 
                    WHERE id = :id";
            
            $stmt = $this->db->Conectar()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':password', $passwordHash);

            $resultado = $stmt->execute();

            $this->db->cerrarBD();

            return $resultado;  // Devuelve true si se actualizó correctamente
        } catch (PDOException $error) {
            throw new Exception("Error en la base de datos: " . $error->getMessage());
        }
    }

    // Método para eliminar un usuario
    public function eliminarUsuario($id) {
        try {
            $this->db = new Conexion();

            // Eliminar el usuario
            $sql = "DELETE FROM usuarios WHERE id = :id";
            
            $stmt = $this->db->Conectar()->prepare($sql);
            $stmt->bindParam(':id', $id);

            $resultado = $stmt->execute();

            $this->db->cerrarBD();

            return $resultado;  // Devuelve true si se eliminó correctamente
        } catch (PDOException $error) {
            throw new Exception("Error en la base de datos: " . $error->getMessage());
        }
    }
}
?>
