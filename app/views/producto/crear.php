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
                <li><a href="../../../public/index.php">Volver atrás</a></li>
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
            
            <form action="../../controllers/ProductoController.php?action=guardar" method="POST">
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
                    <?php foreach($categorias as $categoria): ?>
                        <option value="<?= $categoria['id'] ?>"><?= $categoria['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="imagen">Imagen:</label>
                <input type="file" name="imagen" required>

                <button type="submit">Crear Producto</button>
            </form>
        </div>

    </main>
</body>
</html>