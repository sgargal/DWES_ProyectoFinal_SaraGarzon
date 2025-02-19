<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
</head>
<body>
    <h1>REGISTRO DE USUARIO</h1>
    <form action="../../controllers/UsuarioController.php" method="POST">
        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre" id="nombre" required>

        <label for="email">Email: </label>
        <input type="email" name="email" id="email" required>


        <label for="password">Contraseña: </label>
        <input type="password" name="password" id="password" required>
    </form>
</body>
</html>