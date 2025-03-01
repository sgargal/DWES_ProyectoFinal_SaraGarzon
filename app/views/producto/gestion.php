<?php
require_once '../../controllers/PedidoController.php';
require_once '../../controllers/ProductoController.php';
use Controllers\PedidosController;
use Controllers\ProductoController;

$productoController = new PedidosController;
$productos = $productoController->gestion();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <link rel="stylesheet" href="../../../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <header class="header-form">
        <h1>Gestión de Productos</h1>
        <nav>
            <ul>
                <li><a href="crear.php"><i class="fas fa-plus"></i> Añadir</a></a></li>
                <li><a href="../admin/panelAdmin.php">Volver atrás</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="admin-container">
            <h1>Productos disponibles</h1>
            <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Categoría</th>
                    <th>Imagen</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($productos) && is_array($productos)):?>
                    <?php foreach($productos as $producto): ?>
                        <tr>
                            <td><?= $producto['id'] ?></td>
                            <td><?= $producto['nombre'] ?></td>
                            <td><?= $producto['descripcion'] ?></td>
                            <td><?= $producto['precio'] ?></td>
                            <td><?= $producto['stock'] ?></td>
                            <td><?= $producto['categoria'] ?></td>
                            <td>
                                <img src="../../../src/<?= $producto['imagen'] ?>" width="50" height="50" alt="Imagen">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No se encontraron productos disponibles.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            </table>
        </div>
    </main>
    <footer>
        <?php
            include '../../views/layout/footer.php';
        ?>
    </footer>
</body>
</html>