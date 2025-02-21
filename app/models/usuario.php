<?php

require_once('../config/Conexion.php');

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

    public function hacerAdmin($idUsuario){
        try{
            $conexion = Conexion::Conectar();

            $sqlCheck = "SELECT rol FROM usuarios WHERE id = :id";
            $stmtCheck = $conexion->prepare($sqlCheck);
            $stmtCheck->bindParam(':id', $idUsuario);
            $stmtCheck->execute();
            $usuario = $stmtCheck->fetch(PDO::FETCH_ASSOC);

            //Compruebo que el usuario existe
            if(!$usuario){
                return "El usuario no existe";
            }

            //Compruebo que su rol no sea ya administrador
            if($usuario['rol'] == 'admin'){
                return "El usuario ya es administrador";
            }
           
            //Actualizar el rol a admin
            $sql = "UPDATE usuarios SET rol = 'admin' WHERE id = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id', $idUsuario);

            if($stmt->execute()){
                return "Usuario actualizado a administrador";
            }else{
                return "Error al actualizar el rol del usuario";
            }
        }catch(PDOException $error){
            return "Error en la base de datos: " . $error->getMessage();
        }
    }
}
?>