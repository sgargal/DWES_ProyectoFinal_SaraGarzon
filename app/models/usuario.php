<?php

use Config\Conexion;


class Usuario{
    private $id;
    private $nombre;
    private $apellidos;
    private $email;
    private $password;
    private $rol;

    public function __construct($id, $nombre, $apellidos, $email, $password, $rol){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->password = $password;
        $this->rol = $rol;
    }

    public function getId(){
        return $this->id;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getApellidos(){
        return $this->apellidos;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getRol(){
        return $this->rol;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function setApellidos($apellidos){
        $this->apellidos = $apellidos;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function setRol($rol){
        $this->rol = $rol;
    }

    public function registro(){
        try{
            $conexion = Conexion::Conectar();

            $sql = "INSERT INTO usuarios (nombre, apellidos, email, password, rol) 
                    VALUES (:nombre, :apellidos, :email, :password, :rol)";
                
            $stmt = $conexion->prepare($sql);

            $passwordHash = password_hash($this->password, PASSWORD_BCRYPT);   
    
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':apellidos', $this->apellidos);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $passwordHash);
            $stmt->bindParam(':rol', $this->rol);
    
            if($stmt->execute()){
                return "Usuario registrado correctamente";
            }else{
                return "Error al registrar el usuario";
            }
        }catch(PDOException $error){
            return "Error en la base de datos: " . $error->getMessage();
        }
        
    }

    public function editarUsuario($id, $nombre, $apellidos, $email, $password, $rol) {
        try {
            $conexion = Conexion::Conectar();

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

            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellidos', $apellidos);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':rol', $rol);

            if (!empty($password)) {
                $stmt->bindParam(':password', $passwordHash);
            }

            return $stmt->execute();  // Devuelve true si se actualizó correctamente
        } catch (PDOException $error) {
            throw new Exception("Error en la base de datos: " . $error->getMessage());
        }
    }
}

?>