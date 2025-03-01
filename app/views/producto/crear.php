<?php 
session_start(); 

require_once __DIR__ . '/../../models/Categoria.php';

use App\Models\Categoria;

$categoriaModel = new Categoria();
$categorias = $categoriaModel->obtenerCategorias();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto</title>
    <link rel="stylesheet" href="../../../css/style.css">
</head>
<body>
    <header class="header-form">
        <h1>Crear Producto</h1>
        <nav>
            <ul>
                <li><a href="../producto/gestion.php">Volver atrás</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="formulario-container">
            <?php if(isset($_SESSION['mensaje'])): ?>
                <div class="<?= $_SESSION['mensaje']['tipo'] ?>">
                    <?= $_SESSION['mensaje']['contenido'] ?>
                </div>
                <?php unset($_SESSION['mensaje']); ?>
            <?php endif; ?>
            
            <form action="../../controllers/procesarProducto.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="guardar"> 
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" required>

                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" required></textarea>

                <label for="precio">Precio:</label>
                <input type="number" name="precio" required step="0.01">

                <label for="stock">Stock:</label>
                <input type="number" name="stock" required>

                <label for="categoria_id">Categoría:</label>
                <select name="categoria_id">
                    <?php if (!empty($categorias)): ?>
                        <?php foreach($categorias as $categoria): ?>
                            <option value="<?= htmlspecialchars($categoria['id']) ?>">
                                <?= htmlspecialchars($categoria['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="">No hay categorías disponibles</option>
                    <?php endif; ?>
                </select>

                <label for="imagen">Imagen:</label>
                <input type="file" name="imagen" required>

                <button type="submit">Crear Producto</button>
            </form>
        </div>

    </main>
</body>
</html>