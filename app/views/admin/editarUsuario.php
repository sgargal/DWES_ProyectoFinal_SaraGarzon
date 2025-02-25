<?php
session_start();

require_once '../../../config/Conexion.php';
require_once '../../models/usuario.php';

use Config\Conexion;
use Models\Usuario;

// Verifica si se ha enviado un ID de usuario válido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de usuario no proporcionado.");
}

$idUsuario = $_GET['id'];

try{
    $conexion = Conexion::Conectar();

    // Consulta para obtener los datos actuales del usuario
    $sql = "SELECT * FROM usuarios WHERE id = :id";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id', $idUsuario);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$usuario){
        die("Usuario no encontrado.");
    }
}catch(PDOException $error){
    die("Error en la base de datos: " . $error->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="../../../css/style.css">
</head>
<body>
<header class="header-form">
        <h1>Panel de Administración</h1>
        <nav>
            <ul>
                <li><a href="panelAdmin.php">Volver atrás</a></li>
            </ul>
        </nav>
    </header>
    <div class="admin-container">
        <h2>Editar Usuario</h2>


        <form action="../../controllers/UsuarioController.php" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['id']) ?>">

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>

            <label for="apellidos">Apellidos:</label>
            <input type="text" name="apellidos" value="<?= htmlspecialchars($usuario['apellidos']) ?>" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>

            <label for="password">Nueva Contraseña (opcional):</label>
            <input type="password" name="password">

            <label for="rol">Rol:</label>
            <select name="rol" id="rol-select">
                <option value="usuario" <?= $usuario['rol'] == 'user' ? 'selected' : '' ?>>Usuario</option>
                <option value="admin" <?= $usuario['rol'] == 'admin' ? 'selected' : '' ?>>Administrador</option>
            </select>

            <input type="submit" name="action" value="editarUsuario"></input>
        </form>
    </div>
</body>
</html>