<?php
namespace App\Controllers;

use App\Models\Usuario; // Importa el modelo Usuario


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
                    case 'cambiarPassword': 
                        $this->cambiarPassword();
                        break;
                    case 'eliminarUsuario':
                        $this->eliminarUsuario();
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
        
        if(!$nombre || !$apellidos || !$email || !$password){
            $_SESSION['mensaje'] = ['tipo' => 'error', 'contenido' => "Datos inválidos"];
            header('Location: ../views/usuario/formularioRegistro.php');
            exit();
        }

        $usuario = new Usuario(null, $nombre, $apellidos, $email, $password, 'user');
        $mensaje = $usuario->registro();

        $_SESSION['mensaje'] = ['tipo' => 'success', 'contenido' => $mensaje];
        header('Location: ../../public/index.php');
        exit();
    }

    public function iniciarSesion(){
        $email = $this->validarEmail($_POST['email']);
        $password = $this->validarPassword($_POST['password']);
        
        if(!$email || !$password){
            $_SESSION['mensaje'] = ['tipo' => 'error', 'contenido' => "Datos inválidos"];
            header('Location: ../views/usuario/formularioLogin.php');
            exit();
        }

        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->login($email, $password);

        if(!$usuario){
            $_SESSION['mensaje'] = ['tipo' => 'error', 'contenido' => "Credenciales incorrectas"];
            header('Location: ../views/usuario/formularioLogin.php');
            exit();
        }

        $_SESSION['usuario'] = $usuario;
        $_SESSION['mensaje'] = ['tipo' => 'success', 'contenido' => "Inicio de sesión exitoso"];
        header('Location: ../../public/index.php');
        exit();
    }

    public function cerrarSesion(){
        session_destroy();
        header('Location: ../../public/index.php');
        exit();
    }
    
    public function editarUsuario(){
        // Validación de los datos recibidos
        $id = $_POST['id']; // El id del usuario que se quiere editar
        $nombre = $this->validarNombre($_POST['nombre']);
        $apellidos = $this->validarNombre($_POST['apellidos']);
        $email = $this->validarEmail($_POST['email']);
        $rol = $_POST['rol'];
        $password = !empty($_POST['password']) ? $_POST['password'] : null; // Si hay contraseña, se usará
    
        // Verificamos que los datos sean válidos
        if (!$id || !$nombre || !$apellidos || !$email || !$rol) {
            $_SESSION['mensaje'] = [
                'tipo' => 'error',
                'contenido' => "Datos inválidos"
            ];
            header("Location: ../views/usuario/editarUsuario.php?id=$id");
            exit();
        }
    
        // Llamamos al modelo Usuario para actualizar el usuario
        $usuario = new Usuario($id, $nombre, $apellidos, $email, $password, $rol); // Creando un objeto Usuario con los datos
        if ($usuario->editarUsuario($id, $nombre, $apellidos, $email, $password, $rol)) {
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
    }
    

    public function editarPerfil(){
        $nombre = $this->validarNombre($_POST['nombre']);
        $apellidos = $this->validarNombre($_POST['apellidos']);
        $email = $this->validarEmail($_POST['email']);

        if(!$nombre | !$apellidos | !$email){
            $_SESSION['mensaje'] = ['tipo' => 'error', 'contenido' => 'Datos inválidos'];
            header('Location: ../views/usuario/editarPerfil.php');
            exit();
        }

        $usuario = new Usuario($_SESSION['usuario']['id'], $nombre, $apellidos, $email, null, $_SESSION['usuario']['rol']);
        $mensaje = $usuario->editarUsuario($_SESSION['usuario']['id'], $nombre, $apellidos, $email, null, $_SESSION['usuario']['rol']);

        $_SESSION['mensaje'] = [
            'tipo' => 'success', 
            'contenido' => $mensaje
        ];
        header('Location: ../views/usuario/perfil.php');
        exit();
    }

    public function cambiarPassword() {
        // Verificar si se ha recibido la nueva contraseña
        if (isset($_POST['id']) && isset($_POST['nueva_password']) && isset($_POST['confirmar_password'])) {
            $id = $_POST['id'];
            $nueva_password = $_POST['nueva_password'];
            $confirmar_password = $_POST['confirmar_password'];
    
            // Validar las contraseñas
            if (empty($nueva_password) || empty($confirmar_password)) {
                $_SESSION['mensaje'] = [
                    'tipo' => 'error',
                    'contenido' => 'Las contraseñas no pueden estar vacías.'
                ];
                header("Location: ../views/usuario/cambiarPassword.php?id=$id");
                exit();
            }
    
            if ($nueva_password !== $confirmar_password) {
                $_SESSION['mensaje'] = [
                    'tipo' => 'error',
                    'contenido' => 'Las contraseñas no coinciden.'
                ];
                header("Location: ../views/usuario/cambiarPassword.php?id=$id");
                exit();
            }
    
            // Encriptar la nueva contraseña
            $nueva_password_encriptada = password_hash($nueva_password, PASSWORD_BCRYPT);
    
            // Llamar al modelo para actualizar la contraseña
            $usuario = new Usuario($id);
            if ($usuario->cambiarPassword($id, $nueva_password_encriptada)) {
                $_SESSION['mensaje'] = [
                    'tipo' => 'success',
                    'contenido' => 'Contraseña actualizada correctamente.'
                ];
                header("Location: ../views/admin/panelAdmin.php");
                exit();
            } else {
                $_SESSION['mensaje'] = [
                    'tipo' => 'error',
                    'contenido' => 'Error al cambiar la contraseña.'
                ];
                header("Location: ../views/usuario/cambiarPassword.php?id=$id");
                exit();
            }
        } else {
            $_SESSION['mensaje'] = [
                'tipo' => 'error',
                'contenido' => 'Datos incompletos.'
            ];
            header("Location: ../views/usuario/cambiarPassword.php");
            exit();
        }
    }
    

    public function eliminarUsuario() {
        // Verificar si se ha recibido el id del usuario a eliminar
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
    
            // Llamar al modelo para eliminar el usuario
            $usuario = new Usuario($id);
            if ($usuario->eliminarUsuario($id)) {
                $_SESSION['mensaje'] = [
                    'tipo' => 'success',
                    'contenido' => 'Usuario eliminado correctamente.'
                ];
                header("Location: ../views/admin/panelAdmin.php");
                exit();
            } else {
                $_SESSION['mensaje'] = [
                    'tipo' => 'error',
                    'contenido' => 'Error al eliminar el usuario.'
                ];
                header("Location: ../views/admin/panelAdmin.php");
                exit();
            }
        } else {
            $_SESSION['mensaje'] = [
                'tipo' => 'error',
                'contenido' => 'ID de usuario no proporcionado.'
            ];
            header("Location: ../views/admin/panelAdmin.php");
            exit();
        }
    }
    

    private function validarNombre($nombre){
        $nombre = trim($nombre);
        if(preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $nombre)){
            return $nombre;
        } else {
            $_SESSION['mensaje'] = ['tipo' => 'error', 'contenido' => "El nombre no es válido"];
            header('Location: ../views/usuario/formularioRegistro.php');
            exit();
        }
    }

    public function validarEmail($email){
        $email = trim($email);
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            return $email;
        } else {
            $_SESSION['mensaje'] = ['tipo' => 'error', 'contenido' => "El email no es válido"];
            header('Location: ../views/usuario/formularioRegistro.php');
            exit();
        }
    }

    public function validarPassword($password){
        $password = trim($password);
        if(strlen($password) >= 8){
            return $password;
        } else {
            $_SESSION['mensaje'] = ['tipo' => 'error', 'contenido' => 'La contraseña debe tener al menos 8 caracteres'];
            header('Location: ../views/usuario/formularioRegistro.php');
            exit();
        }
    }
}

new UsuarioController();
