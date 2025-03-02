<?php
require_once __DIR__ . '/../../models/Producto.php';
session_start();

use App\Models\Producto;

$productoModel = new Producto();

// Verificar si se pasó un ID de categoría por la URL
$categoria_id = isset($_GET['categoria']) ? intval($_GET['categoria']) : 0;
$productos = $categoria_id ? $productoModel->obtenerProductosPorCategoria($categoria_id) : [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos por Categoria</title>
    <link rel="stylesheet" href="../../../css/style.css">
</head>
<body>
    <header>
        <h1>Productos de la Categoria</h1>
        <nav>
            <ul>
                <li><a href="../../../public/index.php">Volver atrás</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="productos-container">
            <?php if(!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    <div class="producto-card">
                        <h2><?= htmlspecialchars($producto['nombre']) ?></h2>
                        <p><?= htmlspecialchars($producto['descripcion']) ?></p>
                        <p><strong>Precio:</strong> $<?= htmlspecialchars($producto['precio']) ?></p>
                        <p><strong>Stock:</strong> <?= htmlspecialchars($producto['stock']) ?></p>
                        <img src="../../../src/?= htmlspecialchars($producto['imagen']) ?>" alt="Imagen de <?= htmlspecialchars($producto['nombre']) ?>">
                        <p>Fecha de creación: <?= date('d/m/Y H:i', strtotime($producto['fecha'])) ?></p>
                    </div>
                    <?php endforeach; ?>
            <?php else: ?>
                <p>No hay productos en esta categoría.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>