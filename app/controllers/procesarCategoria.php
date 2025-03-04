<?php
require_once 'CategoriaController.php';
session_start();

use Controllers\CategoriaController;

$categoriaController = new CategoriaController();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'crearCategoria':
                $categoriaController->crearCategoria($_POST['nombre']);
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
