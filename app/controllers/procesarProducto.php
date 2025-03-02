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
            case 'editar':
                $productoController->editar();
                break;
            case 'eliminar':
                if (isset($_POST['id'])) {
                    // Obtenemos el ID del producto desde POST
                    $id = $_POST['id'];
                    $productoController->eliminar($id);  // Llamamos al método eliminar con el ID
                } else {
                    echo "No se ha proporcionado el ID del producto.";
                }
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