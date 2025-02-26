<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear nueva categoría</title>
    <link rel="stylesheet" href="../../../css/style.css">
</head>
<body>
    <header class="header-form">
        <h1>Crear Categoria</h1>
        <nav>
            <ul>
                <li><a href="../categoria/crearCategoria.php">Volver atrás</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="formulario-container">
            <h2>Crear nueva categoría</h2>

            <?php
                if(isset($_SESSION['mensaje'])){
                    $mensaje = $_SESSION['mensaje'];
                    $clase = $mensaje['tipo'] == 'success' ? 'mensaje-exito' : 'mensaje-error';
                    echo '<div class="' . $clase . '">' . $mensaje['contenido'] . '</div>';
                    unset($_SESSION['mensaje']);
                }
            ?>

            <form action="../../controllers/procesarCategoria.php" method="POST">
                <input type="hidden" name="action" value="crearCategoria">
                <label for="nombre">Nombre de la categoría:</label>
                <input type="text" name="nombre" required>
                <button type="submit">Crear Categoría</button>
            </form>
        </div>
    </main>
    <footer>
        <?php
            include '../../views/layout/footer.php';
        ?>
    </footer>
</body>
</html>