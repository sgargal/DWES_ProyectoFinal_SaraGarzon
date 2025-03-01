<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
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
            session_start();
            if (isset($_SESSION['usuario'])) {
        ?>
        <div class="formulario-container">
            <h2>Cambiar contraseña</h2>
            <?php
                if(isset($_SESSION['mensaje'])){
                    $mensaje = $_SESSION['mensaje'];
                    $clase = $mensaje['tipo'] == 'success' ? 'mensaje-exito' : 'mensaje-error';
                    echo '<div class="' . $clase . '">' . $mensaje['contenido'] . '</div>';
                    unset($_SESSION['mensaje']);
                }
            ?>

            <form action="../../controllers/UsuarioController.php" method="POST">
                <input type="hidden" name="action" value="cambiarPassword">
                
                <label for="password_actual">Contraseña Actual</label>
                <input type="password" name="password_actual" required>
                
                <label for="nueva_contraseña">Nueva Contraseña</label>
                <input type="password" name="nueva_contraseña" required>
                
                <label for="confirmar_contraseña">Confirmar Nueva Contraseña</label>
                <input type="password" name="confirmar_contraseña" required>
                
                <button type="submit">Cambiar Contraseña</button>
            </form>
        </div>
        

        <?php
            } else {
                echo "Por favor, inicia sesión para cambiar tu contraseña.";
            }
        ?>
    </main>

</body>
</html>

