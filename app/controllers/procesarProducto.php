<?php
require_once 'ProductoController.php';
session_start();

use Controllers\ProductoController;

$productoController = new ProductoController();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'guardar':
                $productoController->guardar();
                break;
            default:
                echo "Acción no reconocida";
        }
    } else {
        echo "No se ha recibido una acción";
    }
} else {
    echo "Método no permitido";
}
?>