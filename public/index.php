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

        <section class="contenidoPrincipal">
            <?php
            if(isset($_SESSION['mensaje'])){
                $usuario = $_SESSION['usuario'];
                echo '<h2>Bienvenido, ' .htmlspecialchars($usuario['nombre']) . ' ' . htmlspecialchars($usuario['apellidos']) . '</h2>';
                if($usuario['rol'] == 'admin'){
                    echo '<p>Aquí puedes gestionar la tienda</p>';
                }else{
                    echo '<p>Aquí puedes ver los productos de la tienda</p>';
                }
            }else{
                echo '<h2>Bienvenido a la tienda online</h2>';
                echo '<p>Regístrate o inicia sesión para hacer tu pedido</p>';
            }
            ?>
        </section>
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