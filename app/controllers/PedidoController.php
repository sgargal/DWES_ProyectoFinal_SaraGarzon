<?php
namespace Controllers;

require_once __DIR__ . '/../models/Producto.php';

use App\Models\Producto;

class PedidosController {
    public function gestion(){
        $productoModel = new Producto();
        $productos = $productoModel->obtenerProductos();

        // Si no hay productos, $productos es un array vacío
        if ($productos === null) {
            $productos = []; 
        }

        return $productos;

        require_once __DIR__ . '/../views/producto/gestion.php';
    }
}
?>