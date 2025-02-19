<?php
require_once '../config/Conexion.php';

use Config\Conexion;

$conexion = Conexion::Conectar();

if ($conexion) {
    echo "Conexión exitosa";
} else {
    echo "Error en la conexión";
}
?>