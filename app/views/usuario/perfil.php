<?php
session_start();

$usuario = $_SESSION['usuario'];

if(isset($_SESSION['mensaje'])){
    $mensaje = $_SESSION['mensaje'];
    $clase = $mensaje['tipo'] == 'success' ? 'mensaje-exito' : 'mensaje-error';
    echo '<div class="' . $clase . '">' . $mensaje['contenido'] . '</div>';
    unset($_SESSION['mensaje']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="../../../css/style.css">
</head>
<body>
    <header class="header-form">
        <h1>Tienda Online</h1>
        <nav>
            <ul>
                <li><a href="../../../public/index.php">Volver al inicio</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="perfil-container">
            <h1>Bienvenido, <?php echo htmlspecialchars($usuario['nombre']) . ' ' . htmlspecialchars($usuario['apellidos']); ?></h1>

            <div class="perfil-info">
                <h3>Correo electrónico asociado a la cuenta: </h3>
                <p><strong>Email: </strong><?php echo htmlspecialchars($usuario['email']); ?></p>
            </div>

            <div class="acciones">
                <h3>
                    Acciones
                </h3>
                <ul>
                    <li><a href="editarPerfil.php">Editar perfil</a></li>
                    <li><a href="cambiarPassword.php">Cambiar Contraseña</a></li>
                </ul>
            </div>
        </div>
    </main>
    <footer>
        <?php
        include '../layout/footer.php';
        ?>
    </footer>
</body>
</html>