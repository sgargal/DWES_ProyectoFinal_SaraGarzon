<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TIENDA ONLINE</title>
</head>
<body>
    <?php
    include '../app/views/layout/header.php';
    ?>
    <main>
        <aside class="barraLateral">
            <h2>Categorías</h2>
            <ul>
                <li><a href=""></a></li>
                <li><a href=""></a></li>
                <li><a href=""></a></li>
            </ul>
        </aside>
    </main>
</body>
</html>
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