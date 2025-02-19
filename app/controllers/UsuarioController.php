<?php
namespace App\Controllers;

require_once('../config/Conexion.php');

use Config\Conexion;

class UsuarioController{
    public function __construct(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->registrarUsuario();
        }else{
            echo 'No se puede acceder a este recurso';
        }
    }

    public function registrarUsuario(){
        $nombre = $this->validarNombre($_POST['nombre']);
        $apellidos = $this->validarNombre($_POST['apellidos']);
        $email = $this->validarEmail($_POST['email']);
        $password = $this->validarPassword($_POST['password']);

        if(!$nombre || !$apellidos || !$email || !$password){
            die("Datos inválidos");
        }

        $conexion = Conexion::Conectar();


        $sql = "INSERT INTO usuarios(nombre, apellidos, email, password) VALUES(:nombre, :apellidos, :email, :password)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        if($stmt->execute()){
            echo 'Usuario registrado con éxito';
        }else{
            echo 'Error al registrar el usuario';
        }
    }


    private function validarNombre($nombre){
        $nombre = trim($nombre);
        if(preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $nombre)){
            return $nombre;
        }else{
            echo 'El nombre no es válido';
            return false;
        }
    }

    public function validarEmail($email){
        $email = trim($email);
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            return $email;
        }else{
            echo 'El email no es válido';
            return false;
        }
    }

    public function validarPassword($password){
        $password = trim($password);
        if(strlen($password) >= 8){
            return $password;
        }else{
            echo 'La contraseña debe tener al menos 8 caracteres';
            return false;
        }
    }
}

new UsuarioController();
?>