<?php
session_start();

require_once '../../../config/Conexion.php';

use Config\Conexion;
// Verifica si se ha enviado un ID de usuario válido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de usuario no proporcionado.");
}

$idProducto = $_GET['id'];

try{
    $db = new Conexion();

    $sql = "SELECT * FROM productos WHERE id = :id";
    $stmt = $db->Conectar()->prepare($sql);
    $stmt->bindParam(':id', $idProducto);
    $stmt->execute();
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$producto){
        die("Producto no encontrado");
    }
}catch(PDOException $error){
    die("Error en la base de datos: " . $error->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="../../../css/style.css">
    <style>
        .editarProducto-container {
    max-width: 500px;
    margin: 50px auto;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    font-family: Arial, sans-serif;
}

.editarProducto-container label {
    display: block;
    font-weight: bold;
    margin-top: 10px;
    color: #333;
}

.editarProducto-container input {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

.editarProducto-container input:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
}

.editarProducto-container button {
    width: 100%;
    padding: 12px;
    margin-top: 15px;
    background: #05997c;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
}

.editarProducto-container button:hover {
    background:rgb(4, 123, 100);
}

    </style>
</head>
<body>
    <header class="header-form">
        <h1>Panel de Administración</h1>
        <nav>
            <ul>
                <li><a href="../producto/gestion.php">Volver atrás</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="editarProducto-container">
            <form action="../../controllers/procesarProducto.php" method="POST"  enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= htmlspecialchars($producto['id']) ?>" >
                <input type="hidden" name="action" value="editar">

                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required>

                <label for="descripcion">Descripción:</label>
                <input type="text" name="descripcion" value="<?= htmlspecialchars($producto['descripcion']) ?>" required>

                <label for="precio">Precio:</label>
                <input type="number" name="precio" value="<?= htmlspecialchars($producto['precio']) ?>" required>

                <label for="stock">Stock:</label>
                <input type="number" name="stock" value="<?= htmlspecialchars($producto['stock']) ?>" required>

                <label for="categoria_id">Categoría:</label>
                <input type="text" name="categoria_id" value="<?= htmlspecialchars($producto['categoria_id']) ?>" required>

                <!-- Mostrar la imagen actual -->
                <?php if (!empty($producto['imagen'])): ?>
                    <div>
                        <label>Imagen Actual:</label><br>
                        <img src="../../../src/<?= htmlspecialchars($producto['imagen']) ?>" alt="Imagen del producto" style="max-width: 150px;">
                    </div>
                <?php endif; ?>

                <!-- Input para subir una nueva imagen -->
                <label for="imagen">Seleccionar nueva imagen:</label>
                <input type="file" name="imagen">

                <button type="submit">Actualizar Cambios</button>
            </form>
            
        </div>
    </main>
    <footer>
        <?php
        include '../layout/footer.php';
        ?>
    </footer>
</body>
</html>