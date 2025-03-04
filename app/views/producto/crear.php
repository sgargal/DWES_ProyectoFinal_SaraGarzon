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
    <style>
        /* Contenedor principal del formulario */
        .formulario-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 500px;
            margin: 20px auto;
        }

        /* Estilos de los campos del formulario */
        form {
            display: flex;
            flex-direction: column;
        }

        form label {
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        form input,
        form select,
        form textarea {
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        form textarea {
            resize: vertical;
            min-height: 100px;
        }

        form input[type="file"] {
            padding: 5px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }

        /* Estilo para el botón de envío */
        button {
            padding: 12px 20px;
            background-color: #3bcbaf;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
        }

        button:hover {
            background-color:rgb(36, 134, 115);
        }

        /* Estilos específicos para el select */
        select {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f9f9f9;
            font-size: 1rem;
        }

        select:focus {
            border-color: #4CAF50;
            outline: none;
        }

        /* Añadir algo de espaciado entre los elementos del formulario */
        form label,
        form input,
        form select,
        form textarea,
        form button {
            margin-bottom: 12px;
        }
</style>

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