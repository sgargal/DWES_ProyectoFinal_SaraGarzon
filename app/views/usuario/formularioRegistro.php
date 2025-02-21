<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
</head>
<body>
    <h1>REGISTRO DE USUARIO</h1>

    <!-- Mostrar mensaje de la última acción realizada -->
    <?php
        if(isset($_SESSION['mensaje'])){
            echo $_SESSION['mensaje'];
            unset($_SESSION['mensaje']);
        }
    ?>
    <form action="../../controllers/UsuarioController.php" method="POST">
        <input type="hidden" name="action" value="registrarUsuario">
        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre" id="nombre" required>

        <label for="apellidos">Apellidos: </label>
        <input type="text" name="apellidos" id="apellidos" required>

        <label for="email">Email: </label>
        <input type="email" name="email" id="email" required>


        <label for="password">Contraseña: </label>
        <input type="password" name="password" id="password" required>

        <input type="submit" value="Registrar">
    </form>
</body>
</html>