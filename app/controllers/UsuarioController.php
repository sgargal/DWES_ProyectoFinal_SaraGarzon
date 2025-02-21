<?php
namespace App\Controllers;

require_once('../../config/Conexion.php');

use Config\Conexion;

class UsuarioController{
    public function __construct(){
        session_start();
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

        $rol='user';

        if(!$nombre || !$apellidos || !$email || !$password){
            $_SESSION['mensaje'] = "Datos inválidos";
            header('Location: ../views/usuario/formularioRegistro.php');
            exit();
        }

        $conexion = Conexion::Conectar();


        $sql = "INSERT INTO usuarios(nombre, apellidos, email, password, rol) VALUES(:nombre, :apellidos, :email, :password, :rol)";
        $stmt = $conexion->prepare($sql);

        $contraseñaCifrada= password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $contraseñaCifrada);
        $stmt->bindParam(':rol', $rol);

        if($stmt->execute()){
            $_SESSION['mensaje'] = 'Usuario registrado con éxito';
            header('Location: ../../public/index.php');
            exit();
        }else{
            $_SESSION['mensaje'] =  'Error al registrar el usuario';
            header('Location: ../views/usuario/formularioRegistro.php');
            exit();
        }
    }


    private function validarNombre($nombre){
        $nombre = trim($nombre);
        if(preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $nombre)){
            return $nombre;
        }else{
            $_SESSION['mensaje'] = 'El nombre no es válido';
            header('Location: ../views/usuario/formularioRegistro.php');
            exit();
        }
    }

    public function validarEmail($email){
        $email = trim($email);
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            return $email;
        }else{
            $_SESSION['mensaje'] = 'El email no es válido';
            header('Location: ../views/usuario/formularioRegistro.php');
            exit();
        }
    }

    public function validarPassword($password){
        $password = trim($password);
        if(strlen($password) >= 8){
            return $password;
        }else{
            $_SESSION['mensaje'] = 'La contraseña debe tener al menos 8 caracteres';
            header('Location: ../views/usuario/formularioRegistro.php');
            exit();
        }
    }
}

new UsuarioController();
?>