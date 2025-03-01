<?php

namespace Config;

use PDO;
use PDOException;

class Conexion{
    private $conexion;

    public function __construct(){
        define('servidor', 'localhost');
        define('nombre_bd', 'tiendasara');
        define('usuario', 'root');
        define('password', '');

        $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

        try {
            $this->conexion = new PDO("mysql:host=".servidor.";dbname=".nombre_bd, usuario, password, $opciones);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("El error de Conexión es: ". $e->getMessage());
        }
    }

    //Método para obtner la conexion
    public function Conectar() {
       return $this->conexion;
    }

    //Método para cerrar la conexión
    public function cerrarBD(): void {
        $this->conexion = null;
    }

    //Destructor para cerrar la conexion
    public function __destruct(){
        $this->cerrarBD();
    }
}
?>