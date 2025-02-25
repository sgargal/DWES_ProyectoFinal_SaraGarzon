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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <header class="header-inicio">
        <h1>Tienda online</h1>
        <nav>
            <ul>
                <?php if (!$usuarioLogueado): ?> 
                    <!-- SOLO se muestra si NO hay usuario logueado -->
                    <li><a href="../app/views/usuario/formularioRegistro.php">Registrarse</a></li>
                    <li><a href="../app/views/usuario/formularioLogin.php">Iniciar Sesión</a></li>
                <?php else: ?>
                    <!-- SI hay usuario logueado, muestra opciones personalizadas -->
                    <li><a href="/proyectoFinal_SaraGarzon/app/views/carrito/carrito.php">
                        <i class="fa-solid fa-cart-shopping"></i> Carrito
                    </a></li>
                    <li><a href="/proyectoFinal_SaraGarzon/app/views/usuario/perfil.php">Perfil</a></li>
                    <?php if ($_SESSION['usuario']['rol'] == 'admin'): ?>
                        <li><a href="/proyectoFinal_SaraGarzon/app/views/admin/panelAdmin.php">Panel Admin</a></li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
</body>
</html>

