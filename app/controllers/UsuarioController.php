<?php
namespace App\Controllers;

use PDO;
use PDOException;


require_once('../../config/Conexion.php');

use Config\Conexion;

class UsuarioController{
    public function __construct() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['action'])) {
                switch ($_POST['action']) {
                    case 'registrarUsuario':
                        $this->registrarUsuario();
                        break;
                    case 'iniciarSesion':
                        $this->iniciarSesion();
                        break;
                    case 'cerrarSesion':
                        $this->cerrarSesion();
                        break;
                    case 'editarUsuario':
                        $this->editarUsuario();
                        break;
                    case 'editarPerfil':
                        $this->editarPerfil();
                        break;
                    default:
                        echo 'Acción no reconocida';
                        break;
                }
            }
        } else {
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
            $_SESSION['mensaje'] = [
                'tipo' => 'error',
                'contenido' => "Datos inválidos"
            ];
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
            $_SESSION['mensaje'] = [
                'tipo' => 'success',
                'contenido' => 'Usuario registrado con éxito'
            ];
            header('Location: ../../public/index.php');
            exit();
        }else{
            $_SESSION['mensaje'] =  [
                'tipo' => 'error',
                'contenido' => 'Error al registrar el usuario'
            ];
            header('Location: ../views/usuario/formularioRegistro.php');
            exit();
        }
    }

    public function iniciarSesion(){
        $email = $this->validarEmail($_POST['email']);
        $password = $this->validarPassword($_POST['password']);

        if(!$email || !$password){
            $_SESSION['mensaje'] = [
                'tipo' => 'error',
                'contenido' => "Datos inválidos"
            ];
            header('Location: ../views/usuario/formularioLogin.php');
            exit();
        }

        $conexion = Conexion::Conectar();
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        //Si no existe el usuario
        if(!$usuario){
            $_SESSION['mensaje'] = [
                'tipo' => 'error',
                'contenido' => "Este usuario no esta registrado"
            ];
            header('Location: ../views/usuario/formularioLogin.php');
            exit();
        }

        if(password_verify($password, $usuario['password'])){
            $_SESSION['usuario'] = $usuario;
            $_SESSION['mensaje'] = [
                'tipo' => 'success',
                'contenido' => "Inicio de sesión exitoso"
            ];
            header('Location: ../../public/index.php');
            exit();
        }else{
            $_SESSION['mensaje'] = [
                'tipo' => 'error',
                'contenido' => "Contraseña incorrecta"
            ];
            header('Location: ../views/usuario/formularioLogin.php');
            exit();
        }
    }


    public function cerrarSesion(){
        session_destroy();
        header('Location: ../../public/index.php');
        exit();
    }

    public function editarUsuario(){
        if (isset($_POST['action']) && $_POST['action'] == 'editarUsuario') {
            try {
                $conexion = Conexion::Conectar();
    
                // Obtiene los datos del formulario
                $id = $_POST['id'];
                $nombre = $this->validarNombre($_POST['nombre']);
                $apellidos = $this->validarNombre($_POST['apellidos']);
                $email = $this->validarEmail($_POST['email']);
                $rol = $_POST['rol'];
                $password = !empty($_POST['password']) ? $_POST['password'] : null;
    
                if (!$id || !$nombre || !$apellidos || !$email || !$rol) {
                    $_SESSION['mensaje'] = [
                        'tipo' => 'error',
                        'contenido' => "Datos inválidos"
                    ];
                    header("Location: ../views/usuario/editarUsuario.php?id=$id");
                    exit();
                }
    
                // Construcción de la consulta SQL
                if ($password) {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, email = :email, password = :password, rol = :rol WHERE id = :id";
                } else {
                    $sql = "UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, email = :email, rol = :rol WHERE id = :id";
                }
    
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':apellidos', $apellidos);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':rol', $rol);
    
                if ($password) {
                    $stmt->bindParam(':password', $passwordHash);
                }
    
                if ($stmt->execute()) {
                    $_SESSION['mensaje'] = [
                        'tipo' => 'success',
                        'contenido' => 'Usuario actualizado correctamente'
                    ];
                    header("Location: ../views/admin/panelAdmin.php");
                    exit();
                } else {
                    $_SESSION['mensaje'] = [
                        'tipo' => 'error',
                        'contenido' => 'Error al actualizar el usuario'
                    ];
                    header("Location: ../views/usuario/editarUsuario.php?id=$id");
                    exit();
                }
            } catch (PDOException $error) {
                $_SESSION['mensaje'] = [
                    'tipo' => 'error',
                    'contenido' => "Error en la base de datos: " . $error->getMessage()
                ];
                header("Location: ../views/usuario/editarUsuario.php?id=$id");
                exit();
            }
        }
    }

    public function editarPerfil(){
        $nombre = $this->validarNombre($_POST['nombre']);
        $apellidos = $this->validarNombre($_POST['apellidos']);
        $email = $this->validarEmail($_POST['email']);

        if(!$nombre | !$apellidos | !$email){
            $_SESSION['mensaje'] = [
                'tipo' => 'error',
                'contenido' => 'Datos inválidos'
            ];

            header('Location: ../views/usuario/editarPerfil.php');
            exit();
        }

        $conexion = Conexion::Conectar();

        $sql = "UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, email = :email WHERE id = :id";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $_SESSION['usuario']['id']);

        
        if($stmt->execute()){
            $_SESSION['usuario']['nombre']=$nombre;
            $_SESSION['usuario']['apellidos']=$apellidos;
            $_SESSION['usuario']['email']=$email;

            $_SESSION['mensaje']=[
                'tipo'=>'success',
                'contenido'=>'Perfil actualizado con éxito'
            ];

            header('Location: ../views/usuario/perfil.php');
            exit();
        }else{
            $_SESSION['mensaje']= [
                'tipo' => 'error',
                'contenido' => 'Error al actualizar el perfil'
            ];

            header('Location: ../views/usuario/editarPerfil.php');
            exit();
        }
    }
    

    private function validarNombre($nombre){
        $nombre = trim($nombre);
        if(preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $nombre)){
            return $nombre;
        }else{
            $_SESSION['mensaje'] = [
                'tipo' => 'error',
                'contenido' => "El nombre no es válido"
            ];
            header('Location: ../views/usuario/formularioRegistro.php');
            exit();
        }
    }

    public function validarEmail($email){
        $email = trim($email);
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            return $email;
        }else{
            $_SESSION['mensaje'] = [
                'tipo' => 'error',
                'contenido' => "El email no es válido"
            ];
            header('Location: ../views/usuario/formularioRegistro.php');
            exit();
        }
    }

    public function validarPassword($password){
        $password = trim($password);
        if(strlen($password) >= 8){
            return $password;
        }else{
            $_SESSION['mensaje'] = [
                'tipo' => 'error',
                'contenido' => 'La contraseña debe tener al menos 8 caracteres'
            ];
            header('Location: ../views/usuario/formularioRegistro.php');
            exit();
        }
    }

}

new UsuarioController();
?>