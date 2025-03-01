<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario está logueado y si el ID del usuario a eliminar está presente
if (!isset($_SESSION['usuario']) || !isset($_GET['id'])) {
    // Si no hay sesión o no hay ID, redirigir al panel de administración
    header('Location: ../views/admin/panelAdmin.php');
    exit();
}

require_once '../../../config/Conexion.php';

use Config\Conexion;

$usuario_id = $_GET['id'];

// (esto es para mostrar información del usuario que será eliminado)
try {
    $db = new Conexion();
    $sql = "SELECT nombre FROM usuarios WHERE id = :id";
    $stmt = $db->Conectar()->prepare($sql);
    $stmt->bindParam(':id', $usuario_id, PDO::PARAM_INT);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        $_SESSION['mensaje'] = [
            'tipo' => 'error',
            'contenido' => 'El usuario no existe.'
        ];
        header('Location: ../views/admin/panelAdmin.php');
        exit();
    }

    $nombre_usuario = $usuario['nombre'];
} catch (PDOException $error) {
    $_SESSION['mensaje'] = [
        'tipo' => 'error',
        'contenido' => 'Error en la base de datos: ' . $error->getMessage()
    ];
    header('Location: ../views/admin/panelAdmin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Eliminación</title>
    <link rel="stylesheet" href="../../../css/style.css">
</head>
<body>
    <header class="header-form">
        <h1>Tienda Online - Confirmar Eliminación</h1>
        <nav>
            <ul>
                <li><a href="panelAdmin.php">Volver al panel de administración</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="formulario-container">
            <h2>¿Estás seguro de eliminar al siguiente usuario?</h2>
            <p><strong>Nombre del usuario:</strong> <?php echo $nombre_usuario; ?></p>

            <!-- Formulario de confirmación -->
            <form action="../../controllers/UsuarioController.php" method="POST">
                <input type="hidden" name="action" value="eliminarUsuario">
                <input type="hidden" name="id" value="<?php echo $usuario_id; ?>">

                <div class="alerta">
                    <p>Una vez eliminado, no podrás recuperar este usuario. ¿Deseas continuar?</p>
                </div>

                <button type="submit" class="btn-eliminar">Sí, eliminar</button>
                <a href="panelAdmin.php" class="btn-cancelar">Cancelar</a>
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
