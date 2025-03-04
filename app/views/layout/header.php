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
    <style>
        /* Estilo para el botón "Cerrar sesión" */
        .btn-cerrarSesion {
            background-color: #e74c3c; /* Color rojo */
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }

        .btn-cerrarSesion:hover {
            background-color: #c0392b; /* Rojo más oscuro en hover */
            transform: scale(1.05); /* Efecto de escala en hover */
        }
    </style>
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
                    <li><a href="/proyectoFinal_SaraGarzon/app/views/usuario/perfil.php"><i class="fa fa-user"></i> Perfil</a></li>
                    <?php if ($_SESSION['usuario']['rol'] == 'admin'): ?>
                        <li><a href="/proyectoFinal_SaraGarzon/app/views/admin/panelAdmin.php"><i class="fa fa-tools"></i> Panel Admin</a></li>
                    <?php endif; ?>
                    <li>
                        <form action="../app/controllers/UsuarioController.php" method="POST">
                            <input type="hidden" name="action" value="cerrarSesion">
                            <button type="submit" class="btn-cerrarSesion"><i class="fa fa-sign-out-alt"></i> Cerrar sesión</button>
                        </form>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
</body>
</html>

