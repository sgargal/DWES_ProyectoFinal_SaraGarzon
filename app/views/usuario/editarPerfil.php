<?php
session_start();

$usuario = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="../../../css/style.css">
</head>
<body>
    <header class="header-form">
        <h1>Tienda Online</h1>

        <nav>
            <ul>
                <li><a href="perfil.php">Volver atrás</a></li>
            </ul>
        </nav>
    </header>

    <main>
            <?php
                if(isset($_SESSION['mensaje'])){
                    $mensaje = $_SESSION['mensaje'];
                    $clase = $mensaje['tipo'] == 'success' ? 'mensaje-exito' : 'mensaje-error';
                    echo '<div class="' . $clase . '">' . $mensaje['contenido'] . '</div>';
                    unset($_SESSION['mensaje']);
                }
            ?>
        <div class="formulario-container">
            <h1>
                Editar Perfil
            </h1>

            <form action="../../controllers/UsuarioController.php" method="POST">
                <input type="hidden" name="action" value="editarPerfil">

                <label for="nombre">Nombre: </label>
                <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>

                <label for="apellidos">Apellidos: </label>
                <input type="text" name="apellidos" id="apellidos" value="<?php echo htmlspecialchars($usuario['apellidos']); ?>" required>

                <label for="email">Email: </label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>

                <input type="submit" value="Actualizar Información">

            </form>
        </div>
    </main>
</body>
</html>