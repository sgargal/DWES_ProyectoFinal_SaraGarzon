<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../../../css/style.css">
</head>
<body>
    <h1>INICIO DE SESIÓN</h1>

    <?php
        if(isset($_SESSION['mensaje'])){
            echo $_SESSION['mensaje'];
            unset($_SESSION['mensaje']);
        }
    ?>

    <form action="../../controllers/UsuarioController.php" method="POST">
        <input type="hidden" name="action" value="iniciarSesion">
        <label for="email">Email: </label>
        <input type="email" name="email" id="email" required>


        <label for="password">Contraseña: </label>
        <input type="password" name="password" id="password" required>

        <input type="submit" value="Iniciar Sesión">
    </form>

</body>
</html>