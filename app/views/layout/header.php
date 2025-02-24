<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Iniciar sesión solo si no está activa
}
$usuarioLogueado = isset($_SESSION['usuario']); // Verifica si hay sesión activa
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TIENDA</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <header>
        <h1>Tienda online</h1>
        <nav>
            <ul>
                <?php if (!$usuarioLogueado): ?> 
                    <!-- SOLO se muestra si NO hay usuario logueado -->
                    <li><a href="../app/views/usuario/formularioRegistro.php">Registrarse</a></li>
                    <li><a href="../app/views/usuario/formularioLogin.php">Iniciar Sesión</a></li>
                <?php else: ?>
                    <!-- SI hay usuario logueado, muestra opciones personalizadas -->
                    <li><a href="/proyectoFinal_SaraGarzon/app/views/usuario/perfil.php">Perfil</a></li>

                    <?php if ($_SESSION['usuario']['rol'] == 'admin'): ?>
                        <li><a href="../app/views/admin/dashboard.php">Panel Admin</a></li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
</body>
</html>

