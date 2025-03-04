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
    $db = new Conexion();

    // Consulta para obtener los datos actuales del usuario
    $sql = "SELECT * FROM usuarios WHERE id = :id";
    $stmt = $db->Conectar()->prepare($sql);
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
    <style>
        /* Estilos generales del select */
        #rol-select {
            width: 100%;
            padding: 10px;
            font-size: 1rem; 
            border: 1px solid #ccc;
            border-radius: 5px; 
            background-color: #f9f9f9;
            color: #333; 
            appearance: none;
        }
        #rol-select:focus {
            border-color: #007bff; 
            outline: none; 
        }
        #rol-select option {
            padding: 10px;
            background-color: #fff;
            color: #333;
            font-size: 1rem;
        }

        #rol-select option:hover {
            background-color: #f0f0f0; 
        }

    </style>
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
    <main>
        <div class="admin-container">
            <h2>Editar Usuario</h2>


            <form action="../../controllers/UsuarioController.php" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['id']) ?>">
                <input type="hidden" name="action" value="editarUsuario">

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
                    <option value="user" <?= $usuario['rol'] == 'user' ? 'selected' : '' ?>>Usuario</option>
                    <option value="admin" <?= $usuario['rol'] == 'admin' ? 'selected' : '' ?>>Administrador</option>
                </select>

                <br><br>
                <button type="submit"> Editar </button>
            </form>
        </div>
    </main>
    <footer>
        <?php
        include '../layout/footer.php';
        ?>
    </footer>
</body>
</html>